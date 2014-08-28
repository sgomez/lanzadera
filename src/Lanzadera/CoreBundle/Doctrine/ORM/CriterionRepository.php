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
    public function getProductCriterion()
    {
        $query = $this->createQueryBuilder('c');

        $query
            ->where($query->expr()->eq('c.type', Criterion::PRODUCT))
        ;

        return $query;
    }
} 