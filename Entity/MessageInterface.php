<?php

namespace KRG\MessageBundle\Entity;

interface MessageInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Message
     */
    public function setTitle($title);

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Message
     */
    public function setBody($body);

    /**
     * Get body
     *
     * @return string
     */
    public function getBody();

    /**
     * Set thread
     *
     * @param \KRG\MessageBundle\Entity\ThreadInterface $thread
     *
     * @return Message
     */
    public function setThread(ThreadInterface $thread = null);

    /**
     * Get thread
     *
     * @return \KRG\MessageBundle\Entity\ThreadInterface
     */
    public function getThread();

    /**
     * Set user
     *
     * @param \KRG\MessageBundle\Entity\UserInterface $user
     *
     * @return Message
     */
    public function setUser(UserInterface $user = null);

    /**
     * Get user
     *
     * @return \KRG\MessageBundle\Entity\UserInterface
     */
    public function getUser();

    /**
     * Add attachment
     *
     * @param \KRG\MessageBundle\Entity\FileInterface $attachment
     *
     * @return Message
     */
    public function addAttachment(FileInterface $attachment);

    /**
     * Remove attachment
     *
     * @param \KRG\MessageBundle\Entity\FileInterface $attachment
     */
    public function removeAttachment(FileInterface $attachment);

    /**
     * Get attachments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttachments();
}
