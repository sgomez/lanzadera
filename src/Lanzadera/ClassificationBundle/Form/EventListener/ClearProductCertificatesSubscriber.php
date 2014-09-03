<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 3/09/14
 * Time: 12:13
 */

namespace Lanzadera\ClassificationBundle\Form\EventListener;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ClearProductCertificatesSubscriber implements EventSubscriberInterface
{
    private $om;

    /**
     * Constructor
     *
     * @param ObjectManager $om
     */
    function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(FormEvents::POST_SUBMIT => 'postSubmit');
    }

    /**
     * Remove all certificates for one product
     *
     * @param FormEvent $event
     */
    public function postSubmit(FormEvent $event)
    {
        $this->om->persist($product = $event->getForm()->getParent()->getData());
        $this->om->flush();

        $this->om->getRepository('LanzaderaClassificationBundle:Certificate')->clearManualSelection($product, $event->getData());
    }
}