<?php

namespace KRG\MessageBundle\Event;

use KRG\MessageBundle\Sender\SenderInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Templating\EngineInterface;

abstract class AbstractMessage extends Event implements MessageInterface
{
    /**
     * @var boolean
     */
    protected $sent = false;

    /**
     * @var \Exception
     */
    protected $exception;

    public function getFrom()
    {
        return null;
    }

    public function getBcc()
    {
        return array();
    }

    public function getSender()
    {
        return 'mailer';
    }

    public function getAttachments()
    {
        return array();
    }

    public function isSent()
    {
        return $this->sent;
    }

    public function setSent($sent)
    {
        $this->sent = $sent;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }

    public function send(SenderInterface $sender, EngineInterface $templating)
    {
        return $sender->send($this->getTo(), $this->getBody($templating), $this->getSubject(), $this->getFrom(), $this->getBcc(), $this->getAttachments());
    }
}
