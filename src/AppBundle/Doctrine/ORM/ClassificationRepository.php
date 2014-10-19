<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 20/08/14
 * Time: 07:37
 */

namespace AppBundle\Doctrine\ORM;

use Doctrine\ORM\Query\ResultSetMapping;

class ClassificationRepository extends CustomRepository
{
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

    public function getAllKeys()
    {
        $classifications = $this->createQueryBuilder('cl')
            ->select('cl.id as id')
            ->getQuery()
            ->getArrayResult();

        return array_column($classifications, "id");
    }

    /**
     * Calculate the sum of the highest indicator values for each criterion.
     *
     * @param $classification_id
     */
    public function setMaximalValue($classification_id)
    {
        $sql = "
                select sum(max_value) as total from (
                        select max(i.value) as max_value from classification as cl
                        left join criterion as c on c.classification_id = cl.id
                        left join indicator as i on i.criterion_id = c.id
                        where cl.id = :id
                        group by c.id
                ) as parcial
        ";
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('total', 'total');

        $result = $this->_em->createNativeQuery($sql, $rsm)
            ->setParameter('id', $classification_id)
            ->getSingleScalarResult();

        $this->updateMaximum($classification_id, intval($result));
    }

    /**
     * Update the maximum value for one Classification.
     *
     * @param $classification_id
     * @param $value
     */
    private function updateMaximum($classification_id, $value)
    {
        if (null === $value) return;
        $qb = $this->createQueryBuilder('cl');
        $qb->update()
            ->set('cl.maximum', $value)
            ->where($qb->expr()->eq('cl.id', $classification_id))
            ->getQuery()
            ->execute()
        ;
    }
}