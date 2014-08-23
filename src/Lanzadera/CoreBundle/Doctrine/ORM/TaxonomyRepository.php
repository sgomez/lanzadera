<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 09:20
 */

namespace Lanzadera\CoreBundle\Doctrine\ORM;


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

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'taxonomy';
    }
} 