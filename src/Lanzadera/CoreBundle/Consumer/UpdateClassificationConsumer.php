<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 06/09/14
 * Time: 22:22
 */

namespace Lanzadera\CoreBundle\Consumer;

use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Sonata\CoreBundle\Exception\InvalidParameterException;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;

class UpdateClassificationConsumer implements  ConsumerInterface
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
     */
    public function process(ConsumerEvent $event)
    {
        $message = $event->getMessage();

        if (!$message->getValue('classification')) {
            throw new InvalidParameterException();
        }

        $this->om->getRepository('LanzaderaClassificationBundle:Classification')->setMaximalValue(
            $message->getValue('classification')
        );

        $this->logger->debug("Consumer: Update LanzaderaClassificationBundle:Classification with id: " . $message->getValue('classification'));
    }

} 