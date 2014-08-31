<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 31/08/14
 * Time: 11:53
 */

namespace Lanzadera\ClassificationBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Lanzadera\ClassificationBundle\Entity\Indicator;

class IndicatorListener
{
    public function postPersist(Indicator $indicator, LifecycleEventArgs $event)
    {
        $this->updateMaximalValue($indicator, $event);
    }

    public function postUpdate(Indicator $indicator, LifecycleEventArgs $event)
    {
        $this->updateMaximalValue($indicator, $event);
    }

    public function postRemove(Indicator $indicator, LifecycleEventArgs $event)
    {
        $this->updateMaximalValue($indicator, $event);
    }

    private function updateMaximalValue(Indicator $indicator, LifecycleEventArgs $event)
    {
        $em = $event->getEntityManager();
        $classification_id = $indicator->getCriterion()->getClassification()->getId();
        $em->getRepository('LanzaderaClassificationBundle:Classification')
            ->setMaximalValue($classification_id)
        ;
    }
} 