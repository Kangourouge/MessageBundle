<?php

namespace KRG\MessageBundle\Listener;

use KRG\MessageBundle\Event\MessageEvents;
use KRG\MessageBundle\Event\MessageInterface;
use KRG\MessageBundle\Sender\SenderInterface;
use KRG\MessageBundle\Sender\SenderRegistry;
use Symfony\Bundle\TwigBundle\TwigEngine;
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
	 * MessageListener constructor.
	 * @param SenderRegistry $registry
	 * @param EngineInterface $templating
	 * @internal param SenderInterface $sender
	 */
    public function __construct(SenderRegistry $registry, EngineInterface $templating)
    {
        $this->registry = $registry;
        $this->templating = $templating;
    }

    public static function getSubscribedEvents()
    {
        return array(
            MessageEvents::SEND => 'onSend'
        );
    }

    public function onSend(MessageInterface $message) {
        $message->send($this->registry->get($message->getSender()), $this->templating);
    }
}