<?php

namespace KRG\MessageBundle\Service;

use KRG\MessageBundle\Service\Helper\SenderHelperInterface;

class Sender implements SenderInterface
{
    /**
     * @var SenderHelperInterface
     */
    protected $helper;

    /**
     * Sender constructor.
     *
     * @param SenderHelperInterface $helper
     */
    public function __construct(SenderHelperInterface $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param array       $to
     * @param string      $body
     * @param string|null $subject
     * @param null        $from
     * @param array       $bcc
     * @param array       $attachments
     * @return bool
     */
    public function send(array $to, string $body, string $subject = null, $from = null, array $bcc = [], array $attachments = [])
    {
        return $this->helper->send($to, $body, $subject, $from, $bcc, $attachments);
    }
}
