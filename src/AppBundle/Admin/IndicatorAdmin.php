<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;

class IndicatorAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array(
                'label' => 'indicator.name.label',
                'required' => true,
                'attr' => array('title' => 'indicator_name_edit')
            ))
            ->add('value', 'number', array(
                'label' => 'indicator.value.label',
                'required' => true,
                'attr' => array('title' => 'indicator_value_edit')
            ))
        ;
    }
}
