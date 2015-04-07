<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 7/4/15
 * Time: 14:23
 */

namespace Application\Sonata\ClassificationBundle\Doctrine\ORM;


use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ContextRepository extends EntityRepository
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