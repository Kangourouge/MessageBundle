<?php

namespace KRG\MessageBundle\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use KRG\MessageBundle\Entity\BlacklistInterface;
use KRG\MessageBundle\Service\Registry\MessageRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class BlacklistType extends AbstractType
{

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var AuthorizationCheckerInterface */
    protected $authorizationChecker;

    /** @var MessageRegistry */
    protected $messageRegistry;

    /**
     * BlacklistType constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param MessageRegistry $messageRegistry
     */
    public function __construct(EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authorizationChecker, MessageRegistry $messageRegistry)
    {
        $this->entityManager = $entityManager;
        $this->authorizationChecker = $authorizationChecker;
        $this->messageRegistry = $messageRegistry;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
        $builder->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onPostSubmit']);
    }

    public function onPreSetData(FormEvent $event)
    {
        $address = $event->getForm()->getConfig()->getOption('address');
        $event->setData($this->getBlacklists($address));
    }

    public function onPostSubmit(FormEvent $event)
    {
        $blacklists = $this->getAllBlacklists($event->getForm()->getConfig()->getOption('address'));
        $data = $event->getForm()->getData();

        $selectedBlacklist = [];
        foreach($data as $blacklist) {
            $selectedBlacklist[$blacklist->getMessage()] = $blacklist;
        }

        foreach($blacklists as $blacklist) {
            $message = $blacklist->getMessage();
            if (!isset($selectedBlacklist[$message]) && $blacklist->getId() !== null) {
                $this->entityManager->remove($blacklist);
            }
            else if (isset($selectedBlacklist[$message])) {
                $this->entityManager->persist($blacklist);
            }
        }
    }

    protected function getAllBlacklists(string $address) {
        $blacklists = new ArrayCollection();
        /** @var BlacklistInterface $blacklist */
        $blacklist = $this->entityManager->getClassMetadata(BlacklistInterface::class)->getReflectionClass()->newInstance();
        $messages = $this->messageRegistry->all();
        foreach($messages as $className => $message) {
            if ($this->authorizationChecker->isGranted('ROLE_USER', $message)) {
                $blacklistClone = clone($blacklist);
                $blacklistClone->setAddress($address);
                $blacklistClone->setMessage($className);
                $blacklists->set($className, $blacklistClone);
            }
        }

        foreach($this->getBlacklists($address) as $blacklist) {
            $blacklists->set($blacklist->getMessage(), $blacklist);
        }

        return $blacklists;
    }

    protected function getBlacklists(string $address) {
        /** @var EntityRepository $blacklistRepository */
        $blacklistRepository = $this->entityManager->getRepository(BlacklistInterface::class);

        $blacklists = [];
        $_blacklists = $blacklistRepository->findBy(['address' => $address]);
        foreach($_blacklists as $blacklist) {
            $blacklists[$blacklist->getMessage()] = $blacklist;
        }

        return $blacklists;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setRequired('address');
        $resolver->setDefault('expanded', true);
        $resolver->setDefault('multiple', true);
        $resolver->setDefault('choice_translation_domain', 'blacklist');
        $resolver->setDefault('translation_domain', 'messages');
        $resolver->setDefault('label_format', 'form.blacklist.%name%.label');
        $resolver->setDefault('choice_label', function (BlacklistInterface $blacklist, $key, $value) {
            return $blacklist->getMessage();
        });
        $resolver->setNormalizer('choice_loader', function(Options $options){
            return new CallbackChoiceLoader(function() use ($options) {
                return $this->getAllBlacklists($options->offsetGet('address'));
            });
        });
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}