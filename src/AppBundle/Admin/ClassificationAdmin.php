<?php

namespace AppBundle\Admin;

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
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array(
                    'label' => 'classification.name.label'
            ))
            ->add('description', null, array(
                    'label' => 'classification.description.label',
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
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('classification.group.description', array('class' => 'col-md-6'))
                ->add('name', null, array(
                        'label' => 'classification.name.label'
                ))
                ->add('description', 'textarea', array(
                        'label' => 'classification.description.label',
                        'attr' => array('rows' => '6'),
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
     *
     *
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
                    'label' => 'classification.threshold.label',
            ))
            ->add('maximum', null, array(
                    'label' => 'classification.maximum.label'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function postPersist($object)
    {
        $this->getConfigurationPool()->getContainer()->get('sonata.notification.backend')->createAndPublish('backend', array(
                'classification' => $object->getId(),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function postUpdate($object)
    {
        $this->getConfigurationPool()->getContainer()->get('sonata.notification.backend')->createAndPublish('backend', array(
                'classification' => $object->getId(),
            )
        );
    }
}
