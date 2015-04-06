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
                    'label' => 'label.name'
            ))
            ->add('description', null, array(
                    'label' => 'label.description'
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
                    'label' => 'label.name'
            ))
            ->add('description', null, array(
                    'label' => 'label.description',
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
            ->with('label.description', array('class' => 'col-md-6'))
                ->add('name', null, array(
                        'label' => 'label.name'
                ))
                ->add('description', 'textarea', array(
                        'label' => 'label.description',
                        'attr' => array('rows' => '6'),
                ))
            ->end()
            ->with('label.parameters', array('class' => 'col-md-6'))
                ->add('threshold', 'percent', array(
                        'label' => 'label.threshold',
                        'type' => 'integer',
                        'help' => 'help.threshold'
                ))
                ->add('maximum', null, array(
                        'label' => 'label.maximum_value',
                        'help' => 'help.maximum_value',
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
                    'label' => 'label.name'
            ))
            ->add('description', null, array(
                    'label' => 'label.description'
            ))
            ->add('threshold', null, array(
                    'label' => 'label.threshold',
            ))
            ->add('maximum', null, array(
                    'label' => 'label.maximum_value'
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
