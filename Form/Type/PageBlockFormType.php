<?php

/*
 * This file is part of the Melodia Page Bundle
 *
 * (c) Alexey Ryzhkov <alioch@yandex.ru>
 */

namespace Melodia\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageBlockFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'text')
            ->add('keyword', 'text')
            ->add('json', 'text')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Melodia\PageBundle\Entity\PageBlock',
        ));
    }

    public function getName()
    {
        return '';
    }
}
