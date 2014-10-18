<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 09:20
 */

namespace AppBundle\Doctrine\ORM;

class TaxonomyRepository extends CustomRepository
{
    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->select('taxonomy, root, taxons')
            ->leftJoin('taxonomy.root', 'root')
            ->leftJoin('root.children', 'taxons')
            ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getCollectionQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->select('taxonomy, root, taxons')
            ->leftJoin('taxonomy.root', 'root')
            ->leftJoin('root.children', 'taxons')
            ;
    }

    public function createCategoryQuery()
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

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'taxonomy';
    }
} 