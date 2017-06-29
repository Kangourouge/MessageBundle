<?php

namespace KRG\MessageBundle\Listener;

use KRG\MessageBundle\Event\MessageEvents;
use KRG\MessageBundle\Event\MessageInterface;
use KRG\MessageBundle\Sender\SenderRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;

class MessageListener implements EventSubscriberInterface
{
    /**
     * @var SenderRegistry
     */
    private $registry;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * MessageListener constructor.
     *
     * @param SenderRegistry $registry
     * @param EngineInterface $templating
     * @param LoggerInterface $logger
     */
    public function __construct(SenderRegistry $registry, EngineInterface $templating, LoggerInterface $logger)
    {
        $this->registry = $registry;
        $this->templating = $templating;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return array(
            MessageEvents::SEND => 'onSend',
        );
    }

    public function onSend(MessageInterface $message)
    {
        try {
            $ret = $message->send($this->registry->get($message->getSender()), $this->templating);
            $message->setSent((bool)$ret);
            $this->logger->info(sprintf('KRG/MessageBundle: message sent - Return: %s', $ret));
        } catch (\Exception $e) {
            $message->setException($e);
            $this->logger->error(sprintf('An error occurred: %s', $e->getMessage()));
        }
    }
}
