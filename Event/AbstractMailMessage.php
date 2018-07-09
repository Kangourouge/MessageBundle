<?php

namespace KRG\MessageBundle\Event;

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

    public function getSubject()
    {
        return $this->translator->trans(sprintf('mail.%s.subject', $this->getName()), $this->getParams());
    }

    public function getBody()
    {
        return $this->templating->render($this->getTemplate(), $this->options);
    }

    protected function getTemplate() {
        return sprintf('message/%s.html.twig', $this->getName());
    }

    protected function getParams() {
        return [];
    }
}