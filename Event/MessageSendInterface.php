<?php

namespace KRG\MessageBundle\Event;

interface MessageSendInterface
{
    /**
     * @return bool
     */
    public function send();
}
