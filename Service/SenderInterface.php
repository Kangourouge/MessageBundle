<?php

namespace KRG\MessageBundle\Service;

interface SenderInterface
{
    /**
     * @param string $to
     * @param string $body
     * @param string $subject
     * @param string $from
     * @param array $bcc
     * @param array $attachments
     *
     * @return mixed
     */
    public function send(array $to, string $body, string $subject = null, string $from = null, array $bcc = [], array $attachments = []);
}
