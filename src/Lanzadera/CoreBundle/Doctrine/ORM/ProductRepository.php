<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 22/08/14
 * Time: 07:34
 */

namespace Lanzadera\CoreBundle\Doctrine\ORM;


class ProductRepository extends CustomRepository
{
    /**
     * Busca todos los productos de una organización que superen el valor mínimo de una clasificación
     *
     * @param $organization_id
     * @param $classification_id
     * @param $threshold
     *
     * @return array La lista de productos.
     */
    public function getProductsWithClassificationThreshold($organization_id, $classification_id, $threshold)
    {
        $query = $this->createQueryBuilder('p');
        $query
            ->select('p as product')
            ->addSelect('SUM(i.value) as _threshold')
            ->innerJoin('p.organization', 'o')
            ->innerJoin('p.indicators', 'i')
            ->leftJoin('i.criterion', 'c')
            ->leftJoin('c.classification', 'cl')
            ->leftJoin('p.certificates', 'r')
            ->where($query->expr()->eq('o.id', $organization_id))
            ->andWhere($query->expr()->eq('cl.id', $classification_id))
            ->groupBy('p.id')
            ->having($query->expr()->gte('_threshold', $threshold))
        ;

        $result= $query
            ->getQuery()
            ->getResult()
        ;

        return array_column($result, "product");
    }
} 