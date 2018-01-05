<?php

namespace KRG\MessageBundle\Entity;

interface ThreadInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Thread
     */
    public function setActive($active);

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive();

    /**
     * Add message
     *
     * @param MessageInterface $message
     *
     * @return Thread
     */
    public function addMessage(MessageInterface $message);

    /**
     * Remove message
     *
     * @param MessageInterface $message
     */
    public function removeMessage(MessageInterface $message);

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages();
}
