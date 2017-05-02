<?php

namespace KRG\MessageBundle\Sender;

interface SenderInterface {
    public function send($to, $body, $subject = null, $from = null, array $bcc = array(), array $attachments = array());
}
