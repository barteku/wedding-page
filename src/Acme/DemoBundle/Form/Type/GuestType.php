<?php

namespace Acme\DemoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Acme\DemoBundle\Form\EventListener\GuestFieldSubscriber;


class GuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subscriber = new GuestFieldSubscriber($builder->getFormFactory());
        $builder->addEventSubscriber($subscriber);
        
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\DemoBundle\Entity\Guest'
        ));
    }

    public function getName()
    {
        return 'acme_demobundle_guesttype';
    }
}
