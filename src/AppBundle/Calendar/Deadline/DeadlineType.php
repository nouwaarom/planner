<?php

namespace AppBundle\Calendar\Deadline;

use AppBundle\Calendar\Todo\TodoType;
use AppBundle\Calendar\Deadline\Deadline;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('todo', 'collection', array(
                'type' => new TodoType(),
                'allow_add' => true,
                'by_reference' => false,
            ))
            ->add('submit', 'submit')
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Deadline::class,
            'empty_data' => function (FormInterface $form) {
                return Deadline::plan(
                    $form->get('description')->getData(),
                    $form->get('epoch')->getData()
                );
            }
        ));
    }

    public function getName()
    {
        return 'deadline';
    }
}
