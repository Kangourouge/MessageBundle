<?php

namespace KRG\MessageBundle\Service\Helper;

class Mailer implements SenderHelperInterface
{
    /** @var \Swift_Mailer */
    protected $mailer;

    /** @var string */
    protected $from;

    /** @var array|null */
    protected $bcc;

    /**
     * Mailer constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param null          $from
     * @param array         $bcc
     */
    public function __construct(\Swift_Mailer $mailer, $from = null, array $bcc = [])
    {
        $this->mailer = $mailer;
        $this->from = $from;
        $this->bcc = $bcc;
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
        $message = new \Swift_Message($subject, $body, 'text/html');
        $message
            ->setTo($to)
            ->setFrom($from ?: $this->from)
            ->setBcc(array_merge($this->bcc, $bcc));

        foreach ($attachments as $attachment) {
            if (!$attachment instanceof \Swift_Attachment) {
                throw new \InvalidArgumentException('Invalid attachment');
            }
            $message->attach($attachment);
        }

        return (bool) $this->mailer->send($message);
    }
}
