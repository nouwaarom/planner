<?php

namespace AppBundle\Form;

use AppBundle\Entity\Deadline;
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
            ->add('submit', 'submit')
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Deadline',
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
