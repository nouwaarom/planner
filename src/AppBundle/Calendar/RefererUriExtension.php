<?php

namespace AppBundle\Calendar;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RefererUriExtension extends AbstractTypeExtension
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'setRefererUri'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('include_referer_url', false);
    }

    public function setRefererUri(FormEvent $event)
    {
        $form = $event->getForm();

        if (!$form->getConfig()->getOption('include_referer_url')) {
            return;
        }


        $form->add('_redirect_url', 'hidden', array(
            'data' => $this->requestStack->getMasterRequest()->headers->get('referer'),
            'mapped' => false,
        ));
    }

    public function getExtendedType()
    {
        return FormType::class;
    }
}
