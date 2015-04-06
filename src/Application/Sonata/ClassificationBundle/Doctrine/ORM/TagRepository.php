<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 6/4/15
 * Time: 11:31
 */

namespace Application\Sonata\ClassificationBundle\Doctrine\ORM;


use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{
    public function getAll()
    {
        return $this
            ->createQueryBuilder('o')
            ->orderBy('o.name', 'ASC')
        ;
    }
}