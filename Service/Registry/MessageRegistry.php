<?php

namespace KRG\MessageBundle\Service\Registry;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Templating\EngineInterface;

class MessageRegistry
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    private $messages;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var LoggerInterface
     */
    private $logger;

    function __construct(ContainerInterface $container, EngineInterface $templating, LoggerInterface $logger)
    {
        $this->container = $container;
        $this->templating = $templating;
        $this->logger = $logger;
        $this->messages = [];
    }

    /**
     * @param $message
     * @param $name
     */
    public function addMessage($message, $name)
    {
        $this->messages[$name] = $message;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function get($name)
    {
        if (!$this->messages[$name]) {
            throw new \InvalidArgumentException(sprintf('The sender "%s" is not registered with the service container.', $name));
        }

        if (is_string($this->messages[$name])) {
            $this->messages[$name] = $this->container->get($this->messages[$name]);
        }

        return $this->messages[$name];
    }

    /**
     * @return array
     * @throws \Exception$
     */
    public function all()
    {
        foreach ($this->messages as $name => $message) {
            $this->get($name);
        }

        return $this->messages;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->messages[$name]);
    }
}
