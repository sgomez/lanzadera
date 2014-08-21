<?php

namespace Lanzadera\ClassificationBundle\Admin;

use Lanzadera\ClassificationBundle\Entity\Criterion;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CriterionAdmin extends Admin
{
    protected $baseRouteName = "lanzadera_criterion";

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('description')
            ->add('type')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('description')
            ->add('type')
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
            ->with('Descripción')
                ->add('name', null, array(
                    'required' => true,
                    'help' => 'Indique el nombre del criterio de clasificación'
                ))
                ->add('description', 'textarea')
                ->add('type', 'choice', array(
                    'expanded' => true,
                    'choices' => Criterion::getTypes()
                ))
                ->add('classification', null, array(
                    'required' => true,
                ))
            ->end()
            ->with('Parámetros')
                ->add('parameters', 'sonata_type_collection',
                    array(
                        // Prevents the "Delete" option from being displayed
                        'cascade_validation' => true,
                        'type_options' => array('delete' => true),
                        'by_reference' => false,
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
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
            ->add('name')
            ->add('description')
            ->add('type')
        ;
    }
}
