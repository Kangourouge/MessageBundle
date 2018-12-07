<?php

namespace KRG\MessageBundle\Event;

use KRG\MessageBundle\Service\SenderInterface;
use Symfony\Component\Templating\EngineInterface;

interface MessageSendInterface
{
    /**
     * @param SenderInterface $sender
     * @param EngineInterface $templating
     * @return mixed
     */
    public function send();
}
