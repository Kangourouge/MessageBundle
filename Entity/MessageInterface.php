<?php

namespace KRG\MessageBundle\Entity;

use Doctrine\Common\Collections\Collection;
use EMC\FileinputBundle\Entity\FileInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @param ThreadInterface $thread
     *
     * @return Message
     */
    public function setThread(ThreadInterface $thread = null);

    /**
     * Get thread
     *
     * @return ThreadInterface
     */
    public function getThread();

    /**
     * Set user
     *
     * @param UserInterface $user
     *
     * @return Message
     */
    public function setUser(UserInterface $user = null);

    /**
     * Get user
     *
     * @return UserInterface
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
     * @return Collection
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
