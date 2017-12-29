<?php

namespace KRG\MessageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use EMC\FileinputBundle\Entity\FileInterface;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use KRG\UserBundle\Entity\UserInterface;

/**
 * Class Message
 * @package KRG\MessageBundle\Entity
 * @ORM\Entity()
 */
class Message implements MessageInterface, \Serializable
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="KRG\MessageBundle\Entity\ThreadInterface", inversedBy="messages")
     * @ORM\JoinColumn(name="thread_id", referencedColumnName="id")
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="KRG\UserBundle\Entity\UserInterface")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $body;

    /**
     * @ORM\ManyToMany(targetEntity="EMC\FileinputBundle\Entity\FileInterface")
     * @ORM\JoinTable(name="message_attachments",
     *      joinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     * )
     */
    protected $attachments;

    public function __construct()
    {
        $this->attachments = new ArrayCollection();
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->thread,
            $this->user,
            $this->title,
            $this->body,
        ]);
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->thread,
            $this->user,
            $this->title,
            $this->body,
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
     * @return Message
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
     * Set body
     *
     * @param string $body
     *
     * @return Message
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set thread
     *
     * @param \KRG\MessageBundle\Entity\ThreadInterface $thread
     *
     * @return Message
     */
    public function setThread(ThreadInterface $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \KRG\MessageBundle\Entity\ThreadInterface
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set user
     *
     * @param \KRG\MessageBundle\Entity\UserInterface $user
     *
     * @return Message
     */
    public function setUser(UserInterface $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \KRG\MessageBundle\Entity\UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add attachment
     *
     * @param \KRG\MessageBundle\Entity\FileInterface $attachment
     *
     * @return Message
     */
    public function addAttachment(FileInterface $attachment)
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * Remove attachment
     *
     * @param \KRG\MessageBundle\Entity\FileInterface $attachment
     */
    public function removeAttachment(FileInterface $attachment)
    {
        $this->attachments->removeElement($attachment);
    }

    /**
     * Get attachments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttachments()
    {
        return $this->attachments;
    }
}
