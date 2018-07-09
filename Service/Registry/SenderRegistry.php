<?php

namespace KRG\MessageBundle\Service\Registry;

use Symfony\Component\DependencyInjection\ContainerInterface;

class SenderRegistry
{
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
    public function addSender($sender, $name, $alias = null)
    {
        $this->senders[$alias ?: $name] = $sender;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function get($name)
    {
        if (!isset($this->senders[$name])) {
            throw new \InvalidArgumentException(sprintf('The sender "%s" is not registered with the service container.', $name));
        }

        if (is_string($this->senders[$name])) {
            $this->senders[$name] = $this->container->get($this->senders[$name]);
        }

        return $this->senders[$name];
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
        return isset($this->senders[$name]);
    }
}
