<?php

namespace KRG\MessageBundle\Sender\Helper;

use Esendex\Authentication\LoginAuthentication;
use Esendex\DispatchService;
use Esendex\Model\DispatchMessage;
use Esendex\Model\Message;

class Esendex implements SenderHelperInterface {

    /**
     * @var DispatchService
     */
    private $esendex;

    /**
     * Sms constructor.
     * @param $account
     * @param $login
     * @param $password
     */
    public function __construct($account, $login, $password)
    {
        $authentication = new LoginAuthentication($account, $login, $password);
        $this->esendex = new DispatchService($authentication);
    }

    public function send($to, $body, $subject = null, $from = null, array $bcc = array())
    {
        $message = new DispatchMessage($from ?: "Message", $to, $body, Message::SmsType);
        return $this->esendex->send($message);
    }
}
