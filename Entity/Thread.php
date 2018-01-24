<?php

namespace KRG\MessageBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class Thread
 * @package KRG\MessageBundle\Entity
 * @ORM\MappedSuperclass
 */
class Thread implements ThreadInterface
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="KRG\MessageBundle\Entity\MessageInterface", mappedBy="thread", cascade={"all"})
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $messages;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @var bool
     */
    protected $active;

    public function __construct()
    {
        $this->active = true;
        $this->messages = new ArrayCollection();
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
     * Add message
     *
     * @param MessageInterface $message
     *
     * @return Thread
     */
    public function addMessage(MessageInterface $message)
    {
        $this->messages[] = $message;
        $message->setThread($this);

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
     * @return Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
