<?php

namespace KRG\MessageBundle\Service\Helper;

use Esendex\Authentication\LoginAuthentication;
use Esendex\DispatchService;
use Esendex\Model\DispatchMessage;
use Esendex\Model\Message;
use Psr\Log\LoggerInterface;

class Esendex implements SenderHelperInterface
{
    /** @var DispatchService */
    protected $esendex;

    /** @var null|string */
    protected $from;

    /** @var array|string[] */
    protected $bcc;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * Sms constructor.
     *
     * @param $account
     * @param $login
     * @param $password
     */
    public function __construct($account, $login, $password, string $from = null, array $bcc = [], LoggerInterface $logger = null)
    {
        $this->esendex = new DispatchService(new LoginAuthentication($account, $login, $password));
        $this->from = $from;
        $this->bcc = $bcc;
        $this->logger = $logger;
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
        foreach ($to as $_to) {
            $message = new DispatchMessage($from ?: $this->from, $_to, $body, Message::SmsType);

            $result = $this->esendex->send($message);

            if ($this->logger instanceof LoggerInterface) {
                $this->logger->info(sprintf('Message has been sent with Esendex API : %s', json_encode($result)));
            }

            // TODO check messagesremaining and notify admin if it's less than 100
        }

        return true;
    }
}
