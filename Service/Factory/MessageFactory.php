<?php

namespace KRG\MessageBundle\Service\Factory;

use Doctrine\ORM\EntityManagerInterface;
use KRG\MessageBundle\Event\MessageDecorator;
use KRG\MessageBundle\Service\Registry\MessageRegistry;
use KRG\MessageBundle\Service\Registry\SenderRegistry;
use Psr\Log\LoggerInterface;

class MessageFactory
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var SenderRegistry */
    private $senderRegistry;

    /** @var MessageRegistry */
    private $messageRegistry;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(EntityManagerInterface $entityManager, SenderRegistry $senderRegistry, MessageRegistry $messageRegistry, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->senderRegistry = $senderRegistry;
        $this->messageRegistry = $messageRegistry;
        $this->logger = $logger;
    }

    public function create($name, $options = [])
    {
        $message = $this->messageRegistry->get($name);
        $message->setOptions($options);

        return new MessageDecorator($this->entityManager, $this->senderRegistry, $message, $this->logger);
    }
}
