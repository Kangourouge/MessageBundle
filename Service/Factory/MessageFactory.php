<?php

namespace KRG\MessageBundle\Service\Factory;

use KRG\MessageBundle\Entity\MessageInterface;
use KRG\MessageBundle\Service\Registry\MessageRegistry;
use KRG\MessageBundle\Service\Registry\SenderRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Templating\EngineInterface;

class MessageFactory
{
    /**
     * @var SenderRegistry
     */
    private $senderRegistry;

    /**
     * @var MessageRegistry
     */
    private $messageRegistry;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var array
     */
    private $messages;

    /**
     * MessageFactory constructor.
     * @param SenderRegistry  $senderRegistry
     * @param MessageRegistry $messageRegistry
     * @param EngineInterface $templating
     * @param LoggerInterface $logger
     */
    public function __construct(SenderRegistry $senderRegistry, MessageRegistry $messageRegistry, EngineInterface $templating, LoggerInterface $logger)
    {
        $this->senderRegistry = $senderRegistry;
        $this->messageRegistry = $messageRegistry;
        $this->templating = $templating;
        $this->logger = $logger;
        $this->messages = [];
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

        $this->messages[] = $message;

        return $this;
    }

    public function send()
    {
        if (empty($this->messages)) {
            throw new \Exception('There is no message to send.');
        }

        foreach ($this->messages as $key => $message) {
            try {
                $sender = $this->senderRegistry->get($message->getSender());
                $ret = $message->send($sender, $this->templating);
                $message->setSent((bool)$ret);
                $this->logger->info(sprintf('KRG/MessageBundle: message sent - Return: %s', $ret));
            } catch (\Exception $e) {
                $message->setException($e);
                $this->logger->error(sprintf('An error occurred: %s', $e->getMessage()));
            }

            unset($this->messages[$key]);
        }
    }
}
