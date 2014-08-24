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
use Doctrine\ORM\Query\Expr;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

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

    public function createTaxonQuery($type)
    {
        $query = $this->createQueryBuilder('t');

        $query
            ->leftJoin('t.taxonomy', 'y')
            ->where($query->expr()->eq('y.name', '?1'))
            ->andWhere($query->expr()->isNotNull('t.parent'))
            ->orderBy('t.left')
            ->setParameter('1', $type)
        ;

        return $query;
    }
} 