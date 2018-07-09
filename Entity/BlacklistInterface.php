<?php

namespace KRG\MessageBundle\Entity;

interface BlacklistInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @return string
     */
    public function getAddress(): string;

    /**
     * @param string $address
     *
     * @return BlacklistInterface
     */
    public function setAddress(string $address): BlacklistInterface;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param string $message
     *
     * @return BlacklistInterface
     */
    public function setMessage(string $message): BlacklistInterface;
}