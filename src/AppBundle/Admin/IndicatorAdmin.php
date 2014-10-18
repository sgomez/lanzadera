<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;

class IndicatorAdmin extends Admin
{
	/**
	 * {@inheritdoc}
	 */
	protected $baseRouteName = "lanzadera_indicator";

	/**
	 * {@inheritdoc}
	 */
	protected $baseRoutePattern = 'lanzadera/indicator';
	
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array(
                'label' => 'label.name',
                'required' => true,
                'attr' => array('title' => 'indicator_name_edit')
            ))
            ->add('value', 'number', array(
                'label' => 'label.value',
                'required' => true,
                'attr' => array('title' => 'indicator_value_edit')
            ))
        ;
    }
}
