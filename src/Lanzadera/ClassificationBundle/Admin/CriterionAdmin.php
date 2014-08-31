<?php

namespace Lanzadera\ClassificationBundle\Admin;

use Lanzadera\ClassificationBundle\Entity\Criterion;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvents;

class CriterionAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = "lanzadera_criterion";

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array(
                    'label' => 'criterion.name.label'
            ))
            ->add('description', null, array(
                    'label' => 'criterion.description.label'
            ))
            ->add('type', null, array(
                    'label' => 'criterion.type.label'
                ), 'criterion_type', array(
                    'expanded' => false,
                    'constraints' => array(),
                )
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, array(
                    'label' => 'criterion.name.label'
            ))
            ->add('description', null, array(
                    'label' => 'criterion.description.label'
            ))
            ->addIdentifier('classification', null, array(
                    'label' => 'criterion.classification.label'
            ))
            ->add('type', 'string', array(
                    'label' => 'criterion.type.label',
                    'template' => 'LanzaderaClassificationBundle:CRUD:list_criterion_type.html.twig'
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
        $this->getConfigurationPool()->getContainer()->get('ladybug')->log($this->getSubject()->getId());
        $formMapper
            ->with('criterion.group.description', array('class' => 'col-md-6'))
                ->add('name', null, array('label' => 'criterion.name.label', 'required' => true))
                ->add('description', 'textarea', array('label' => 'criterion.description.label'))
                ->add('type', 'criterion_type', array(
                    'label' => 'criterion.type.label',
                    'disabled' => !$this->getSubject()->isNew(),
                ))
                ->add('classification', null, array(
                    'label' => 'criterion.classification.label',
                    'required' => true,
                ))
            ->end()
            ->with('criterion.group.indicators', array('class' => 'col-md-6'))
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
            ->add('name', null, array(
                    'label' => 'criterion.name.label'
            ))
            ->add('description', null, array(
                    'label' => 'criterion.description.label'
            ))
            ->add('type', 'string', array(
                    'label' => 'criterion.type.label',
                    'template' => 'LanzaderaClassificationBundle:CRUD:show_criterion_type.html.twig'
                ))
        ;
    }
}
