<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 06/09/14
 * Time: 18:31
 */

namespace Lanzadera\CoreBundle\Consumer;


use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Sonata\CoreBundle\Exception\InvalidParameterException;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;

class LanzaderaBackendConsumer implements ConsumerInterface
{
    /** @var LoggerInterface $logger */
    private $logger;

    private $om;

    function __construct(LoggerInterface $logger, ObjectManager $om)
    {
        $this->logger = $logger;
        $this->om = $om;
    }


    /**
     * Process a ConsumerEvent
     *
     * @param ConsumerEvent $event
     * @throw InvalidParameterException
     */
    public function process(ConsumerEvent $event)
    {
        $message = $event->getMessage();

        if (!$message->getValue('classification')) {
            throw new InvalidParameterException();
        }

        $classification_id = $message->getValue('classification');

        $this->logger->debug("Se ha llamado al backend con el valor ".$classification_id);

        $classifications = $this->om->getRepository('LanzaderaClassificationBundle:Classification')->findAll();

        foreach ($classifications as $classification) {
            $this->om->getRepository('LanzaderaOrganizationBundle:Organization')->evaluateProductsByClassification(
                $classification->getId()
            );
        }

//
//        if ("all" === $classification_id) {
//            $classifications = $this->om->getRepository('LanzaderaClassificationBundle:Classification')->getAllKeys();
//        } else {
//            $classifications = array($classification_id);
//        }
//
//        foreach ($classifications as $classification) {
//            $this->om->getRepository('LanzaderaOrganizationBundle:Organization')->evaluateProductsByClassification(
//                $classification
//            );
//        }
    }
}