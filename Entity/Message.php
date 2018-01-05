<?php

namespace KRG\MessageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use EMC\FileinputBundle\Entity\FileInterface;
use KRG\UserBundle\Entity\UserInterface;

/**
 * Class Message
 * @package KRG\MessageBundle\Entity
 * @ORM\Entity()
 */
class Message implements MessageInterface
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
     * @var ThreadInterface
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="KRG\UserBundle\Entity\UserInterface")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var UserInterface
     */
    protected $user;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $body;

    /**
     * @ORM\ManyToMany(targetEntity="EMC\FileinputBundle\Entity\FileInterface", cascade={"all"})
     * @ORM\JoinTable(name="message__attachment",
     *      joinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     * )
     * @var Collection
     */
    protected $attachments;

    public function __construct()
    {
        $this->attachments = new ArrayCollection();
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
     * @param ThreadInterface $thread
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
     * @return ThreadInterface
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set user
     *
     * @param UserInterface $user
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
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add attachment
     *
     * @param FileInterface $attachment
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
     * @param FileInterface $attachment
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

    /**
     * Set Attachments
     *
     * @param Collection $attachments
     *
     * @return $this
     */
    public function setAttachments(Collection $attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }
}
