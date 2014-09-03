<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 20/08/14
 * Time: 07:37
 */

namespace Lanzadera\CoreBundle\Doctrine\ORM;


class ClassificationRepository extends CustomRepository
{
    public function CertificatedByProducts($product)
    {
        return $this
            ->createQueryBuilder('cl')
            ->leftJoin('cl.certificates', 'cr')
            ->where('cr.product = ?1')
            ->setParameter(1, $product)
        ;
    }

    public function getChoices()
    {
        $classifications = $this->createQueryBuilder('cl')
            ->select('cl.id as id, cl.name as name')
            ->getQuery()
            ->getArrayResult();

        $result = array();
        foreach($classifications as $classification) {
            $result[$classification['id']] = $classification['name'];
        }

        return $result;
    }

    /**
     * Calculate the sum of the highest indicator values for each criterion.
     *
     * @param $id
     */
    public function setMaximalValue($id)
    {
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder();
        $subquery = $em->createQueryBuilder();

        $subquery->select($query->expr()->max('i2.value'))
            ->from('LanzaderaClassificationBundle:Indicator', 'i2')
            ->where($query->expr()->eq('i2.criterion', 'i.criterion'))
        ;

        $query
            ->from('LanzaderaClassificationBundle:Classification', 'cl')
            ->add('select', 'SUM(i.value)')
            ->innerJoin('cl.criteria', 'c')
            ->innerJoin('c.indicators', 'i')
            ->where($query->expr()->eq('cl.id', $id))
            ->andWhere($query->expr()->in('i.value', $subquery->getDQL()))
        ;

        $result = $query
            ->getQuery()
            ->getSingleScalarResult()
        ;

        $this->update($id, $result);
    }

    private function update($id, $value)
    {
        if (null === $value) return;
        $qb = $this->createQueryBuilder('cl');
        $qb->update()
            ->set('cl.maximum', $value)
            ->where($qb->expr()->eq('cl.id', $id))
            ->getQuery()
            ->execute()
        ;
    }
}