<?php

namespace KRG\MessageBundle\Service;

interface SenderInterface
{
    public function send($to, $body, $subject = null, $from = null, array $bcc = [], array $attachments = []);
}
