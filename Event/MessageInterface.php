<?php

namespace KRG\MessageBundle\Event;

use KRG\MessageBundle\Sender\SenderInterface;
use Symfony\Component\Templating\EngineInterface;

interface MessageInterface
{
    /**
     * @return string
     */
    public function getSender();

    /**
     * @return string
     */
    public function getFrom();

    /**
     * @return string
     */
    public function getTo();

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @return string
     */
    public function getBody(EngineInterface $templating);

    /**
     * @return string[]
     */
    public function getBcc();

    /**
     * @param SenderInterface $sender
     * @return mixed
     */
    public function send(SenderInterface $sender, EngineInterface $templating);
}