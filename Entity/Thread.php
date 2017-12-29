<?php

namespace KRG\MessageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class Thread
 * @package KRG\MessageBundle\Entity
 * @ORM\Entity()
 */
class Thread implements ThreadInterface, \Serializable
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="KRG\UserBundle\Entity\UserInterface")
     * @ORM\JoinTable(name="thread_users",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="thread_id", referencedColumnName="id", unique=true)}
     * )
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="MessageInterface", mappedBy="thread")
     */
    protected $messages;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @var bool
     */
    protected $active;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->users,
            $this->messages,
            $this->title,
            $this->active,
        ]);
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->users,
            $this->messages,
            $this->title,
            $this->active,
            ) = unserialize($serialized);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Thread
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Thread
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add user
     *
     * @param UserInterface $user
     *
     * @return Thread
     */
    public function addUser(UserInterface $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param UserInterface $user
     */
    public function removeUser(UserInterface $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add message
     *
     * @param MessageInterface $message
     *
     * @return Thread
     */
    public function addMessage(MessageInterface $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param MessageInterface $message
     */
    public function removeMessage(MessageInterface $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }


    /**
     * @return UserInterface
     */
    public function createdBy()
    {
        return $this->getMessages()->first()->getUser();
    }
}
