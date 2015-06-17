<?php

namespace AppBundle\Form;

use AppBundle\Entity\Todo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datetime', 'datetime', array(
                'data' => new \DateTime(),
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ))
            ->add('description', 'text')
            ->add('priority', 'integer')
            ->add('todo', 'collection', array(
                'type' => new TodoType(),
                'allow_add' => true,
                'by_reference' => false,
            ))
            ->add('submit', 'submit')
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', 'AppBundle\Entity\Appointment');
    }

    public function getName()
    {
        return 'appointment';
    }
}
