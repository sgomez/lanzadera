<?php
/**
 * This file is part of the lanzadera package.
 *
 * (c) Sergio Gómez
 *
 * For the full copyright and licence information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lanzadera\CoreBundle\Doctrine\ORM;

class OrganizationRepository extends CustomRepository
{
    public function evaluateProductsByClassification($classification_id)
    {
        if (null === $classification_id) return;

        $em = $this->getEntityManager();
        $classification = $em->getRepository('LanzaderaClassificationBundle:Classification')->find($classification_id);
        $threshold = intval($classification->getMaximum() * $classification->getThreshold() / 100);

        if (!$classification) {
            throw new \InvalidArgumentException();
        }

        $organizations = $this->findAllWithValuesByClassification($classification_id);

        foreach ($organizations as $organization) {
            $limit = $threshold - ($organization['value'] ? $organization['value'] : 0);
            $products = $em->getRepository('LanzaderaProductBundle:Product')
                ->getProductsWithClassificationThreshold($organization['id'], $classification_id, $limit);

            foreach ($products as $product) {
                $product['product']->addClassification($classification);
                $em->persist($product['product']);
            }

        }
        $em->flush();
    }

    public function findAllWithValuesByClassification($classification_id)
    {
        $query = $this->createQueryBuilder('o');
        $query
            ->select('o.id as id')
            ->addSelect('SUM(i.value) as value')
            ->leftJoin('o.indicators', 'i')
            ->leftJoin('i.criterion', 'c')
            ->leftJoin('c.classification', 'cl')
            ->where($query->expr()->eq('cl.id', $classification_id))
            ->orWhere($query->expr()->isNull('cl.id'))
            ->groupBy('o.id')
        ;

        return $query
            ->getQuery()
            ->getArrayResult()
            ;
    }

//SELECT o0_.id AS id0, SUM(i1_.value)
//FROM organization o0_
//LEFT JOIN organization_has_indicator o2_ ON o0_.id = o2_.organization_id
//LEFT JOIN indicator i1_ ON i1_.id = o2_.indicator_id
//LEFT JOIN criterion c3_ ON i1_.criterion_id = c3_.id
//LEFT JOIN classification c4_ ON c3_.classification_id = c4_.id
//WHERE c4_.id = 115 OR c4_.id IS NULL
//GROUP BY id0
//;

    public function getProductsWithClassificationThreshold($organization_id, $classification_id, $threshold)
    {
        $query = $this->createQueryBuilder('o');
        $query
            ->select('o as organization, p as product')
            ->addSelect('SUM(i.value) as _threshold')
            ->innerJoin('o.products', 'p')
            ->innerJoin('p.indicators', 'i')
            ->leftJoin('i.criterion', 'c')
            ->leftJoin('c.classification', 'cl')
            ->where($query->expr()->eq('o.id', $organization_id))
            ->andWhere($query->expr()->eq('cl.id', $classification_id))
            ->groupBy('p.id')
            ->having($query->expr()->gte('_threshold', $threshold))
        ;

        return $query
            ->getQuery()
            ->getResult()
        ;
    }
}


//
//select o.name as empresa, p.name as producto, i.name, sum(i.value)
//from organization as o
//inner join product as p on p.organization_id = o.id
//inner join product_has_indicator as pi on pi.product_id = p.id
//left join indicator as i on i.id = pi.indicator_id
//left join criterion as c on c.id = i.criterion_id
//left join classification as cl on cl.id = c.classification_id
//where cl.id = 116
//and o.id = 323
//group by p.id
//having sum(i.value) > 22
//;