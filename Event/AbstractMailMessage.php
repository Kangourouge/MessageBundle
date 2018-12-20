<?php

namespace KRG\MessageBundle\Event;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

abstract class AbstractMailMessage extends AbstractMessage
{
    /** @var TranslatorInterface */
    protected $translator;

    /** @var EngineInterface */
    protected $templating;

    /**
     * CreateProspectMessage constructor.
     *
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating, TranslatorInterface $translator, string $from = null, array $bcc = [])
    {
        parent::__construct($from, $bcc);

        $this->templating = $templating;
        $this->translator = $translator;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('sender', 'mailer');
    }

    public function getParameters(Options $options, array $parameters)
    {
        return $parameters;
    }

    public function getSubject(array $parameters = [])
    {
        return $this->translator->trans(sprintf('message.%s.subject', $this->getName()), $parameters);
    }

    public function getBody(array $parameters = null)
    {
        $parameters = array_replace(['message_name' => $this->getName()], $parameters ?: $this->options);
        return $this->templating->render($this->getTemplate(), $parameters);
    }

    protected function getTemplate() {
        return sprintf('message/%s.html.twig', $this->getName());
    }
}