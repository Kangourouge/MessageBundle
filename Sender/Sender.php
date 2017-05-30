<?php

namespace KRG\MessageBundle\Sender;

use KRG\MessageBundle\Sender\Helper\SenderHelperInterface;

class Sender implements SenderInterface
{
    /**
     * @var SenderHelperInterface
     */
    protected $helper;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var array|null
     */
    protected $bcc;

    /**
     * Sender constructor.
     *
     * @param SenderHelperInterface $helper
     * @param string $from
     * @param array|null $bcc
     */
    public function __construct(SenderHelperInterface $helper, $from, array $bcc = array())
    {
        $this->helper = $helper;
        $this->from = $from;
        $this->bcc = $bcc;
    }

    public function send($to, $body, $subject = null, $from = null, array $bcc = array(), array $attachments = array())
    {
        return $this->helper->send($to, $body, $subject, $from ?: $this->from, array_merge($bcc, $this->bcc), $attachments);
    }
}
