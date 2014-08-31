<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 21/08/14
 * Time: 23:23
 */

namespace Lanzadera\CoreBundle\Doctrine\ORM;


use Lanzadera\ClassificationBundle\Entity\Criterion;

class CriterionRepository extends CustomRepository
{
    public function getMaximalIndicatorValue($id)
    {
        $query = $this->createQueryBuilder('c');
        $result = $query
            ->select($query->expr()->max('i.value'))
            ->leftJoin('c.indicators', 'i')
            ->where($query->expr()->eq('c.id', $id))
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return intval($result);
    }

    public function getProductCriterion()
    {
        $query = $this->createQueryBuilder('c');

        $query
            ->where($query->expr()->eq('c.type', Criterion::PRODUCT))
        ;

        return $query;
    }
} 