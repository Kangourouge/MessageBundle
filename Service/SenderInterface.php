<?php

namespace KRG\MessageBundle\Service;

interface SenderInterface
{
    /**
     * @param array       $to
     * @param string      $body
     * @param string|null $subject
     * @param null        $from
     * @param array       $bcc
     * @param array       $attachments
     * @return bool
     */
    public function send(array $to, string $body, string $subject = null, $from = null, array $bcc = [], array $attachments = []);
}
