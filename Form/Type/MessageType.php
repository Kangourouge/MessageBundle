<?php

namespace KRG\MessageBundle\Form\Type;

use EMC\FileinputBundle\Form\Type\FileinputType;
use KRG\MessageBundle\Entity\MessageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('body', TextareaType::class, [
                    'required' => false
                ])
                ->add('attachments', FileinputType::class, [
                    'multiple' => true,
                    'required' => false,
                    'drop_zone' => true,
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', MessageInterface::class);
    }
}