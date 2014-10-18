<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 06/09/14
 * Time: 18:31
 */

namespace AppBundle\Consumer;

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

        $classifications = $this->om->getRepository('AppBundle:Classification')->findAll();

        foreach ($classifications as $classification) {
            $this->om->getRepository('AppBundle:Classification')->setMaximalValue(
                $classification->getId()
            );

            $this->om->getRepository('AppBundle:Organization')->evaluateProductsByClassification(
                $classification->getId()
            );
        }
    }
}