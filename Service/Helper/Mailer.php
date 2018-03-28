<?php

namespace KRG\MessageBundle\Service\Helper;

class Mailer implements SenderHelperInterface
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * Mailer constructor.
     *
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param       $to
     * @param       $body
     * @param null  $subject
     * @param null  $from
     * @param array $bcc
     * @param array $attachments
     * @return int
     */
    public function send($to, $body, $subject = null, $from = null, array $bcc = [], array $attachments = [])
    {
        $message = (new \Swift_Message($subject, $body, 'text/html'))
            ->setTo($to)
            ->setFrom($from)
            ->setBcc($bcc);

        foreach ($attachments as $attachment) {
            if (!$attachment instanceof \Swift_Attachment) {
                throw new \InvalidArgumentException('Invalid attachment');
            }
            $message->attach($attachment);
        }

        return $this->mailer->send($message);
    }
}
