<?php

namespace KRG\MessageBundle\Form\Type;

use EMC\FileinputBundle\Form\Type\FileinputType;
use KRG\MessageBundle\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('body')
                ->add('attachments', FileinputType::class, [
                    'multiple' => true,
                    'required' => false
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Message::class);
    }
}