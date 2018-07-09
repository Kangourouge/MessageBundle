<?php

namespace KRG\MessageBundle\Event;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use KRG\MessageBundle\Entity\BlacklistInterface;
use KRG\MessageBundle\Service\Registry\SenderRegistry;
use KRG\MessageBundle\Service\SenderInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Templating\EngineInterface;

abstract class AbstractMessage extends Event implements MessageInterface
{
    /** @var string */
    protected $from;

    /** @var array|null */
    protected $bcc;

    /** @var boolean */
    protected $sent;

    /** @var \Exception */
    protected $exception;

    /** @var array */
    protected $options;

    /**
     * AbstractMessage constructor.
     *
     * @param string|null $from
     * @param array $bcc
     */
    public function __construct(string $from = null, array $bcc = [])
    {
        $this->from = $from;
        $this->bcc = $bcc;
        $this->sent = false;
    }

    /**
     * @return null|string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return array|string[]
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('sender', 'mailer');
        $resolver->setAllowedTypes('sender', ['string', SenderInterface::class]);
    }

    /**
     * @param array $options
     *
     * @return MessageInterface
     */
    public function setOptions(array $options = [])
    {
        $resolver = new OptionsResolver();

        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);

        return $this;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getOption($name) {
        return $this->options[$name];
    }

    /**
     * @return array|\Swift_Attachment[]
     */
    public function getAttachments()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function isSent()
    {
        return $this->sent;
    }

    /**
     * @param $sent
     *
     * @return MessageInterface
     */
    public function setSent($sent)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param \Exception $exception
     *
     * @return MessageInterface
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;

        return $this;
    }

    public function getName() {
        return strtolower(preg_replace(array('/^\\\/', '/Message/', '/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'), array('', '', '\\1_\\2', '\\1_\\2'), strrchr(static::class, '\\')));
    }
}
