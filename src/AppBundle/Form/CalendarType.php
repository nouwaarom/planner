<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datetime', 'datetime')
            ->add('description', 'text')
            ->add('priority', 'integer')
            ->add('submit', 'submit')
            ->getForm()
        ;
    }

    public function getName()
    {
        return 'calendar';
    }
}
