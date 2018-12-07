<?php

namespace KRG\MessageBundle\Event;

use Symfony\Component\OptionsResolver\OptionsResolver;

interface MessageInterface
{
    /**
     * @return array|string[]
     */
    public function getTo();

    /**
     * @return null|string
     */
    public function getFrom();

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @return array|string[]
     */
    public function getBcc();

    /**
     * @return string
     */
    public function getBody();

    /**
     * @return array|\Swift_Attachment[]
     */
    public function getAttachments();

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
}
