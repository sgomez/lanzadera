<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 08:05
 */

namespace AppBundle\Doctrine\ORM;

use AppBundle\Entity\Product;
use Doctrine\ORM\Query\Expr;
use Sylius\Component\Taxonomy\Model\TaxonomyInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;

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

	public function findAllCategories()
	{
		$queryBuilder = $this->getCollectionQueryBuilder();
		$query = $queryBuilder
			->select('PARTIAL o.{id,name,slug}')
			->addSelect('COUNT(product.id) as _count')
			->leftJoin('o.taxonomy', 'taxonomy')
			->leftJoin('o.products', 'product')
			->leftJoin('product.organization', 'organization')
			->where($queryBuilder->expr()->eq('taxonomy.name', ':taxonomy'))
			->andWhere($queryBuilder->expr()->isNotNull('o.parent'))
			->andWhere($queryBuilder->expr()->eq('product.status', ':status'))
			->andWhere($queryBuilder->expr()->eq('organization.enabled', ':enabled'))
			->groupBy('o.id')
			->orderBy('o.name')
			->setParameter('taxonomy', 'Category')
			->setParameter(':status', Product::STATUS_APPROVED)
			->setParameter(':enabled', 1)
			->getQuery()
			->getArrayResult()
		;

		return $query;
	}

} 