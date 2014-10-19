<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 3/09/14
 * Time: 12:13
 */

namespace AppBundle\Form\EventListener;

use AppBundle\Entity\Product;
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
	    $product = $event->getForm()->getParent()->getData();

	    if ($product && $product instanceof Product) {
		    $this->om->persist( $product );
		    $this->om->flush();

		    $this->om->getRepository( 'AppBundle:Certificate' )->clearManualSelection( $product, $event->getData() );
	    }
    }
}