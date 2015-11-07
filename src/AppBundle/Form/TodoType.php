<?php

namespace AppBundle\Form;

use AppBundle\Entity\Todo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', Type\TextType::class, array(
                'required' => true, // is default value
            ))
            ->add('done', Type\HiddenType::class, array(
                'mapped' => false,
            ))
            ->add('submit', Type\SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Todo',
            'empty_data' => function (FormInterface $form) {
                return Todo::writeDown($form->get('description')->getData());
            },
        ));
    }

    public function getName()
    {
        return 'todo';
    }
}
