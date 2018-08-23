<?php

namespace KRG\MessageBundle\Event;

use Psr\Log\LoggerInterface;
use KRG\MessageBundle\Service\SenderInterface;
use KRG\MessageBundle\Entity\BlacklistInterface;
use KRG\MessageBundle\Service\Registry\SenderRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageDecorator implements MessageInterface, MessageSendInterface
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var SenderRegistry */
    protected $senderRegistry;

    /** @var LoggerInterface */
    protected $logger;

    /** @var MessageInterface */
    private $message;

    public function __construct(EntityManagerInterface $entityManager, SenderRegistry $senderRegistry, LoggerInterface $logger, MessageInterface $message)
    {
        $this->entityManager = $entityManager;
        $this->senderRegistry = $senderRegistry;
        $this->message = $message;
        $this->logger = $logger;
    }

    public function getTo()
    {
        return $this->message->getTo();
    }

    public function getFrom()
    {
        return $this->message->getFrom();
    }

    public function getSubject()
    {
        return $this->message->getSubject();
    }

    public function getBcc()
    {
        return $this->message->getBcc();
    }

    public function getBody()
    {
        return $this->message->getBody();
    }

    public function getAttachments()
    {
        return $this->message->getAttachments();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $this->message->configureOptions($resolver);
    }

    public function setOptions(array $options = [])
    {
        return $this->message->setOptions($options);
    }

    public function isSent()
    {
        return $this->message->isSent();
    }

    public function setSent($sent)
    {
        return $this->message->setSent($sent);
    }

    public function getException()
    {
        return $this->message->getException();
    }

    public function setException(\Exception $exception)
    {
        return $this->message->setException($exception);
    }

    private function getBlacklist(array $addresses)
    {
        /** @var EntityRepository $blacklistRepository */
        $blacklistRepository = $this->entityManager->getRepository(BlacklistInterface::class);

        $data = $blacklistRepository->createQueryBuilder('blacklist')
            ->select('blacklist.address')
            ->andWhere('blacklist.address in (:addresses)')
            ->andWhere('blacklist.message = :message')
            ->setParameter('addresses', array_map('KRG\MessageBundle\Entity\Blacklist::canonicalize', $addresses))
            ->setParameter('message', get_parent_class($this->message))
            ->getQuery()
                ->getScalarResult();

        return array_column($data, 'address');
    }

    public function send()
    {
        try {
            $to = $this->getTo();

            if (is_string($to)) {
                $to = (array)$to;
            }

            $to = array_diff($to, $this->getBlacklist($to));
            if (count($to) === 0) {
                return true;
            }

            /** @var SenderInterface $sender */
            $sender = $this->senderRegistry->get($this->message->getOption('sender'));

            return $this->sent = $sender->send(
                $to,
                $this->getBody(),
                $this->getSubject(),
                $this->getFrom(),
                $this->getBcc(),
                $this->getAttachments()
            );
        } catch (\Exception $exception) {
            $this->exception = $exception;
            $this->logger->error($exception->getMessage());
        }

        $this->sent = false;

        return false;
    }

}
