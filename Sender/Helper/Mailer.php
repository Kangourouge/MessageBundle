<?php

namespace KRG\MessageBundle\Sender\Helper;

class Mailer implements SenderHelperInterface {

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
     * @param \Swift_Mailer $mailer
     */
    public function setMailer(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($to, $body, $subject = null, $from = null, array $bcc = array(), array $attachments = array())
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setTo('celmechrafi@kangourouge.com')
            ->setBcc($bcc)
            ->setBody($body)
            ->setContentType('text/html')
        ;

        if ($from !== null) {
            $message->setFrom($from);
        }

        foreach ($attachments as $attachment) {
            if (!$attachment instanceof \Swift_Attachment) {
                throw new \InvalidArgumentException('Invalid attachment');
            }
            $message->attach($attachment);
        }
dump($message);
//        die;
        return $this->mailer->send($message);
    }
}
