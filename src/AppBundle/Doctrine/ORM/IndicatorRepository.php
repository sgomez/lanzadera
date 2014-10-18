<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 26/08/14
 * Time: 05:11
 */

namespace AppBundle\Doctrine\ORM;

use Doctrine\ORM\Query\Expr;

class IndicatorRepository extends CustomRepository
{
    public function findOneByCriterionAndName($criterion, $name)
    {
        $query = $this->createQueryBuilder('i');
        $query->leftJoin('i.criterion', 'c')
            ->where($query->expr()->like('c.name', '?1'))
            ->andWhere($query->expr()->like('i.name', '?2'))
            ->setParameter('1', $criterion)
            ->setParameter('2', $name)
        ;

        $result = $query
            ->getQuery()
            ->getOneOrNullResult();

        return $result;
    }
}