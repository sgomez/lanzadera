<?php

namespace Lanzadera\ClassificationBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ClassificationAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'lanzadera_classification';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array(
                    'label' => 'classification.name.label'
            ))
            ->add('description', null, array(
                    'label' => 'classification.description.label'
            ))
            ->add('threshold', null, array(
                    'label' => 'classification.threshold.label'
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array(
                    'label' => 'classification.name.label'
            ))
            ->add('description', null, array(
                    'label' => 'classification.description.label'
            ))
            ->add('threshold', null, array(
                    'label' => 'classification.threshold.label',
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('classification.group.description', array('class' => 'col-md-6'))
                ->add('name', null, array(
                        'label' => 'classification.name.label'
                ))
                ->add('description', 'textarea', array(
                        'label' => 'classification.description.label'
                ))
            ->end()
            ->with('classification.group.parameters', array('class' => 'col-md-6'))
                ->add('threshold', 'percent', array(
                        'label' => 'classification.threshold.label',
                        'type' => 'integer',
                        'help' => 'classification.threshold.help'
                ))
                ->add('maximum', null, array(
                        'label' => 'classification.maximum.label',
                        'help' => 'classification.maximum.help',
                        'read_only' => true,
                        'required' => false
                ))
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array(
                    'label' => 'classification.name.label'
            ))
            ->add('description', null, array(
                    'label' => 'classification.description.label'
            ))
            ->add('threshold', null, array(
                    'label' => 'classification.threshold.label'
            ))
        ;
    }
}
