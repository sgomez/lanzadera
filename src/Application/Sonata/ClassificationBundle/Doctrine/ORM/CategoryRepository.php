<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 06/04/15
 * Time: 21:53
 */

namespace Application\Sonata\ClassificationBundle\Doctrine\ORM;


use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    /**
     * @param mixed $id
     *
     * @return null|object
     */
    public function find($id)
    {
        if (is_array($id)) {
            $id = current($id);
        }

        return parent::find($id);
    }
}