<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 31/08/14
 * Time: 16:00
 */

namespace Lanzadera\ClassificationBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Lanzadera\ClassificationBundle\Entity\Classification;

class ClassificationListener
{
    public function postPersist(Classification $classification, LifecycleEventArgs $event)
    {
        $this->updateProductClassification($classification, $event);
    }

    public function postUpdate(Classification $classification, LifecycleEventArgs $event)
    {
        $this->updateProductClassification($classification, $event);
    }

    public function postRemove(Classification $classification, LifecycleEventArgs $event)
    {
        $this->updateProductClassification($classification, $event);
    }

    private function updateProductClassification(Classification $classification, LifecycleEventArgs $event)
    {
        $em = $event->getEntityManager();
        $classification_id = $classification->getId();
        $em->getRepository('LanzaderaOrganizationBundle:Organization')
            ->evaluateProductsByClassification($classification_id)
        ;
    }
} 