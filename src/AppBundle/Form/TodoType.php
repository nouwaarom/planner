<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'text', array(
                'required' => true, // is default value
            ))
            ->add('done', 'hidden', array(
                'data' => false,
            ))
            ->add('submit', 'submit')
        ;
    }

    public function getName()
    {
        return 'todo';
    }
}
