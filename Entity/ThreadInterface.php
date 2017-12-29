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
     * Set title
     *
     * @param string $title
     *
     * @return Thread
     */
    public function setTitle($title);

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();

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
     * Add user
     *
     * @param UserInterface $user
     *
     * @return Thread
     */
    public function addUser(UserInterface $user);

    /**
     * Remove user
     *
     * @param UserInterface $user
     */
    public function removeUser(UserInterface $user);

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers();

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


    /**
     * @return UserInterface
     */
    public function createdBy();
}
