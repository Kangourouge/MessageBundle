<?php

namespace KRG\MessageBundle\Entity;

use Doctrine\Common\Collections\Collection;
use EMC\FileinputBundle\Entity\FileInterface;
use KRG\UserBundle\Entity\UserInterface;

interface MessageInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

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
     * @param \KRG\UserBundle\Entity\UserInterface $user
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
     * @param FileInterface $attachment
     *
     * @return Message
     */
    public function addAttachment(FileInterface $attachment);

    /**
     * Remove attachment
     *
     * @param FileInterface $attachment
     */
    public function removeAttachment(FileInterface $attachment);

    /**
     * Get attachments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttachments();

    /**
     * Set Attachments
     *
     * @param Collection $attachments
     *
     * @return $this
     */
    public function setAttachments(Collection $attachments);
}
