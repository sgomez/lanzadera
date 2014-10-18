<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 2/09/14
 * Time: 13:33
 */

namespace AppBundle\Doctrine\ORM;

use Lanzadera\ProductBundle\Entity\Product;

class CertificateRepository extends CustomRepository
{
    public function clearManualSelection(Product $product, array $classification)
    {
        if (!$classification) { $classification = array(''); }
        $qb = $this->createQueryBuilder('cert');

        $query = $qb
            ->delete()
            ->where($qb->expr()->eq('cert.product', $product->getId()))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->in('cert.classification', $classification),
                $qb->expr()->eq('cert.auto', 0)
            ))
            ->getQuery()
        ;

        return $query->execute();
    }

    public function clearAutoSelection($classification_id)
    {
        $qb = $this->createQueryBuilder('cert');

        $query = $qb
            ->delete()
            ->where($qb->expr()->eq('cert.classification', $classification_id))
            ->andWhere($qb->expr()->eq('cert.auto', 1))
            ->getQuery()
        ;

        return $query->execute();
    }
}