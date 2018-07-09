<?php

namespace KRG\MessageBundle\Service\Factory;

use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use KRG\MessageBundle\Entity\MessageInterface;
use KRG\MessageBundle\Event\MessageDecorator;
use KRG\MessageBundle\Service\Registry\MessageRegistry;
use KRG\MessageBundle\Service\Registry\SenderRegistry;
use Symfony\Component\Templating\EngineInterface;

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

    /**
     * MessageFactory constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param SenderRegistry $senderRegistry
     * @param MessageRegistry $messageRegistry
     */
    public function __construct(EntityManagerInterface $entityManager, SenderRegistry $senderRegistry, MessageRegistry $messageRegistry)
    {
        $this->entityManager = $entityManager;
        $this->senderRegistry = $senderRegistry;
        $this->messageRegistry = $messageRegistry;
    }

    /**
     * @param       $name
     * @param array $options
     * @return $this
     * @throws \Exception
     */
    public function create($name, $options = [])
    {
        $message = $this->messageRegistry->get($name);
        $message->setOptions($options);

        return new MessageDecorator($this->entityManager, $this->senderRegistry, $message);
    }
}
