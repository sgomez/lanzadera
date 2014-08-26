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
            ->add('name', null, array('label' => 'criterion.name.label'))
            ->add('description', null, array('label' => 'criterion.description.label'))
            ->add('type', null, array('label' => 'criterion.type.label'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'criterion.name.label'))
            ->add('description', null, array('label' => 'criterion.description.label'))
            ->add('type', null, array('label' => 'criterion.type.label'))
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
            ->with('criterion.group.description')
                ->add('name', null, array('label' => 'criterion.name.label', 'required' => true))
                ->add('description', 'textarea', array('label' => 'criterion.description.label'))
                ->add('type', 'choice', array(
                    'label' => 'criterion.type.label',
                    'expanded' => true,
                    'choices' => Criterion::getTypes()
                ))
                ->add('classification', null, array(
                    'label' => 'criterion.classification.label',
                    'required' => true,
                ))
            ->end()
            ->with('criterion.group.indicators')
                ->add('indicators', 'sonata_type_collection',
                    array(
                        'label' => 'criterion.indicator.label',
                        'cascade_validation' => true,
                        'type_options' => array('delete' => true),
                        'by_reference' => false,
                        'btn_add' => $this->trans('criterion.indicator.add')
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
            ->add('name', null, array('label' => 'criterion.name.label'))
            ->add('description', null, array('label' => 'criterion.description.label'))
            ->add('type', null, array('label' => 'criterion.type.label'))
        ;
    }
}
