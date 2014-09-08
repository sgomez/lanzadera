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

use Lanzadera\ClassificationBundle\Entity\Certificate;
use Lanzadera\ProductBundle\Entity\Product;

class OrganizationRepository extends CustomRepository
{
    public function findAllActives()
    {
        $qb = $this->createQueryBuilder('o');
        $query = $qb
            ->select('partial o.{id, name}')
            ->addSelect('partial m.{id, providerReference}')
            ->leftJoin('o.media', 'm')
            ->where($qb->expr()->eq('o.enabled', 1))
        ;

        return $query->getQuery()->getArrayResult();
    }

    public function evaluateProductsByClassification($classification_id)
    {
        $em = $this->getEntityManager();
        $classification = $em->getRepository('LanzaderaClassificationBundle:Classification')->find($classification_id);
        if (!$classification) {
            throw new \InvalidArgumentException();
        }

        $em->getRepository('LanzaderaClassificationBundle:Certificate')->clearAutoSelection($classification_id);
        $threshold = intval($classification->getMaximum() * $classification->getThreshold() / 100);
        $organizations = $this->findAll();

        foreach ($organizations as $organization) {
            $organization_id = $organization->getId();
            $value =  $this->getOrganizationValueByClassification($organization_id, $classification_id);
            $limit = $threshold - intval($value);

            $products = $em->getRepository('LanzaderaProductBundle:Product')
                ->getProductsWithClassificationThreshold($organization_id, $classification_id, $limit);

            /** @var Product $product */
            foreach ($products as $product) {
                $certificate = $em->getRepository('LanzaderaClassificationBundle:Certificate')
                    ->findOneBy(array('product' => $product, 'classification' => $classification));

                if ($certificate) continue;

                $certificate = new Certificate();
                $certificate->setAuto(true);
                $certificate->setClassification($classification);
                $product->addCertificate($certificate);
                $em->persist($product);
            }

        }
        $em->flush();
    }

    /**
     * Devuelve todas las organizaciones y la suma de los indicadores para una clasificación.
     *
     * @param $classification_id
     * @return array
     */
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

    public function getOrganizationValueByClassification($organization_id, $classification_id)
    {
        $qb = $this->createQueryBuilder('o');
        $query = $qb
            ->select('SUM(i.value) as value')
            ->leftJoin('o.indicators', 'i')
            ->leftJoin('i.criterion', 'c')
            ->leftJoin('c.classification', 'cl')
            ->where($qb->expr()->eq('cl.id', $classification_id))
            ->andWhere($qb->expr()->eq('o.id', $organization_id))
        ;

        return $query
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
