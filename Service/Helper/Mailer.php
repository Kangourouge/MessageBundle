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

    public function send($to, $body, $subject = null, $from = null, array $bcc = [], array $attachments = [])
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setTo($to)
            ->setFrom($from)
            ->setBcc($bcc)
            ->setBody($body)
            ->setContentType('text/html');

        foreach ($attachments as $attachment) {
            if (!$attachment instanceof \Swift_Attachment) {
                throw new \InvalidArgumentException('Invalid attachment');
            }
            $message->attach($attachment);
        }

        return $this->mailer->send($message);
    }
}
