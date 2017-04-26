<?php

namespace KRG\MessageBundle\Event;

use KRG\MessageBundle\Sender\SenderInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Templating\EngineInterface;

abstract class AbstractMessage extends Event implements MessageInterface
{

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

    public function send(SenderInterface $sender, EngineInterface $templating)
    {
        return $sender->send($this->getTo(), $this->getBody($templating), $this->getSubject(), $this->getFrom(), $this->getBcc());
    }

}