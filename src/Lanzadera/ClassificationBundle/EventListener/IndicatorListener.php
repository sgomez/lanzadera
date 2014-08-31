<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 31/08/14
 * Time: 11:53
 */

namespace Lanzadera\ClassificationBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Lanzadera\ClassificationBundle\Entity\Indicator;

class IndicatorListener
{
    public function postPersist(Indicator $indicator, LifecycleEventArgs $event)
    {
        $this->updateMaximaValue($indicator, $event);
    }

    public function postUpdate(Indicator $indicator, LifecycleEventArgs $event)
    {
        $this->updateMaximaValue($indicator, $event);
    }

    public function postRemove(Indicator $indicator, LifecycleEventArgs $event)
    {
        $this->updateMaximaValue($indicator, $event);
    }

    private function updateMaximaValue(Indicator $indicator, LifecycleEventArgs $event)
    {
        $em = $event->getEntityManager();
        $em->getRepository('LanzaderaClassificationBundle:Classification')
            ->setMaximalValue($indicator->getCriterion()->getClassification()->getId())
        ;
    }
} 