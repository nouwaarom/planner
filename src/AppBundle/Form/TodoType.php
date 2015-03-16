<?php

namespace AppBundle\Form;

use AppBundle\Entity\Todo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'text', array(
                'required' => true, // is default value
            ))
            ->add('done', 'hidden', array(
                'mapped' => false,
            ))
            ->add('submit', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $options)
    {
        $options->setDefaults(array(
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
