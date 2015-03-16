<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DeadlineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('epoch', 'datetime', array(
                'data' => new \DateTime(),
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ))
            ->add('description', 'text')
            ->add('submit', 'submit')
            ->getForm();
    }

    public function getName()
    {
        return 'deadline';
    }
}
