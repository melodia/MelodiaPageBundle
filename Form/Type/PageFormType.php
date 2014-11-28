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
use Melodia\PageBundle\Form\DataTransformer\StringToBooleanTransformer;

class PageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url')
            ->add('pageBlocks', 'collection', array(
                'type' =>  new PageBlockFormType(),
                'allow_add' => true,
                'allow_delete' => true,
                'label' => ' ',
            ))
            ->add($builder->create('isActive', 'text')->addViewTransformer(new StringToBooleanTransformer()))
            ->add('title')
            ->add('description')
            ->add('keywords')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Melodia\PageBundle\Entity\Page',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return '';
    }
}
