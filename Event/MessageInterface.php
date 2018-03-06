<?php

namespace KRG\MessageBundle\Event;

use KRG\MessageBundle\Service\SenderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Templating\EngineInterface;

interface MessageInterface
{
    /**
     * @return null|string
     */
    public function getFrom();

    /**
     * @return array|string[]
     */
    public function getBcc();

    /**
     * @return string
     */
    public function getSender();

    /**
     * @param OptionsResolver $resolver
     * @return mixed|void
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * @param array $options
     * @return mixed|void
     */
    public function setOptions(array $options = []);

    /**
     * @return array|\Swift_Attachment[]
     */
    public function getAttachments();

    /**
     * @return bool
     */
    public function isSent();

    /**
     * @param $sent
     */
    public function setSent($sent);

    /**
     * @return \Exception
     */
    public function getException();

    /**
     * @param \Exception $exception
     */
    public function setException(\Exception $exception);

    /**
     * @param SenderInterface $sender
     * @param EngineInterface $templating
     * @return mixed
     */
    public function send(SenderInterface $sender, EngineInterface $templating);
}
