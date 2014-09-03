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
        return array(FormEvents::PRE_SUBMIT => 'preSubmit');
    }

    /**
     * Remove all certificates for one product
     *
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $id = $event->getForm()->getParent()->getData('id');
        $certificates = $this->om->getRepository('LanzaderaClassificationBundle:Certificate')->findBy(array('product' => $id));
        foreach($certificates as $certificate) {
            $this->om->remove($certificate);
        }
        $this->om->flush();
    }
}