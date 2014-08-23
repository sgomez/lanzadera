<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 08:05
 */

namespace Lanzadera\CoreBundle\Doctrine\ORM;


use Sylius\Bundle\TaxonomiesBundle\Model\TaxonomyInterface;
use Sylius\Bundle\TaxonomiesBundle\Repository\TaxonRepositoryInterface;

class TaxonRepository extends CustomRepository implements TaxonRepositoryInterface
{
    public function getTaxonsAsList(TaxonomyInterface $taxonomy)
    {
        return $this->getQueryBuilder()
            ->where('o.taxonomy = :taxonomy')
            ->andWhere('o.parent IS NOT NULL')
            ->setParameter('taxonomy', $taxonomy)
            ->orderBy('o.left')
            ->getQuery()
            ->getResult()
            ;
    }

    public function createTaxonQuery()
    {
        $query = $this->createQueryBuilder('t');

        $query
            ->where(
                $query->expr()->isNull('t.taxonomy')
            )
            ->orderBy(
                't.left'
            )
        ;

        return $query;
    }
} 