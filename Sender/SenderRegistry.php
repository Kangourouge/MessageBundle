<?php

namespace KRG\MessageBundle\Sender;

use Symfony\Component\DependencyInjection\Container;

class SenderRegistry {

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var array
     */
    private $senders;

    function __construct(array $senders) {
        $this->senders = $senders;
    }

    /**
     * @param Container $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * @param $name
     *
     * @return SenderInterface
     */
    public function get($name) {
        
        if (!array_key_exists($name, $this->senders)) {
            throw new \InvalidArgumentException(sprintf('The sender "%s" is not registered with the service container.', $name));
        }
        
        if (is_string($this->senders[$name])) {
            $this->senders[$name] = $this->container->get($this->senders[$name]);
        }
        
        return $this->senders[$name];
    }

    /**
     * @return array
     */
    public function all() {
        foreach($this->senders as $name => $sender) {
            $this->get($name);
        }
        
        return $this->senders;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name) {
        return isset($this->senders[$name]);
    }
}