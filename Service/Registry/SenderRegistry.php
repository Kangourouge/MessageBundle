<?php

namespace KRG\MessageBundle\Service\Registry;

use Symfony\Component\DependencyInjection\ContainerInterface;

class SenderRegistry
{
    const SENDER_PREFIX = 'krg.message.';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    private $senders;

    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->senders = [];
    }

    /**
     * @param $sender
     * @param $name
     */
    public function addSender($sender, $name)
    {
        $this->senders[$name] = $sender;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function get($name)
    {
        if (!array_key_exists(self::SENDER_PREFIX.$name, $this->senders)) {
            throw new \InvalidArgumentException(sprintf('The sender "%s" is not registered with the service container.', $name));
        }

        if (is_string($this->senders[self::SENDER_PREFIX.$name])) {
            $this->senders[self::SENDER_PREFIX.$name] = $this->container->get($this->senders[self::SENDER_PREFIX.$name]);
        }

        return $this->senders[self::SENDER_PREFIX.$name];
    }

    /**
     * @return array
     * @throws \Exception$
     */
    public function all()
    {
        foreach ($this->senders as $name => $sender) {
            $this->get($name);
        }

        return $this->senders;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->senders[self::SENDER_PREFIX.$name]);
    }
}
