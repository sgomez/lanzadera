<?php

namespace AppBundle\Admin;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CriterionAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = "lanzadera_criterion";

    /**
     * {@inheritdoc}
     */
    protected $formOptions = array(
        'cascade_validation' => true
    );

    /**
     * {@inheritdoc}
     */
    protected $datagridValues = array(
        '_page' => 1,            // display the first page (default = 1)
        '_sort_order' => 'ASC', // reverse order (default = 'ASC')
        '_sort_by' => 'name'  // name of the ordered field
    );

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);
        $query->leftJoin(current($query->getRootAliases()).'.classification', 'cl');
        $query->addSelect('cl');
        return $query;
    }

    /**
     * {@inheritdoc}
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
            ->add('classification.name', null, array(
                    'label' => 'label.classification',
            ))
            ->add('type', null, array(
                    'label' => 'label.type'
                ), 'criterion_type', array(
                    'expanded' => false,
                    'constraints' => array(),
                )
            )
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
            ->add('classification.name', null, array(
                    'label' => 'label.classification'
            ))
            ->add('type', 'string', array(
                    'label' => 'label.type',
                    'template' => 'Criterion/CRUD/list_criterion_type.html.twig'
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
        $disabled = $this->getSubject()->isNew() ? false : true;

        $formMapper
            ->with('label.description', array('class' => 'col-md-6'))
                ->add('name', null, array('label' => 'label.name', 'required' => true))
                ->add('description', 'textarea', array('label' => 'label.description'))
                ->add('type', 'criterion_type', array(
                    'label' => 'label.type',
                    'disabled' => $disabled,
                ))
                ->add('classification', null, array(
                    'label' => 'label.classification',
                    'required' => true,
                ))
            ->end()
            ->with('label.indicators', array('class' => 'col-md-6'))
                ->add('indicators', 'sonata_type_collection',
                    array(
                        'label' => 'label.indicators',
                        'type_options' => array('delete' => true),
                        'by_reference' => false,
                        'btn_add' => $this->trans('label.indicator_add'),
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
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('criterion.group.description', array('class' => 'col-md-6'))
                ->add('name', null, array(
                        'label' => 'label.name'
                ))
                ->add('classification.name', null, array(
                        'label' => 'label.classification'
                ))
                ->add('description', null, array(
                    'label' => 'label.description'
                ))
                ->add('type', 'string', array(
                        'label' => 'label.type',
                        'template' => 'Criterion/CRUD/show_criterion_type.html.twig'
                ))
            ->end()
            ->with('criterion.group.indicators', array('class' => 'col-md-6'))
                ->add('indicators', null, array(
                        'label' => 'label.indicators',
                        'template' => 'Criterion/CRUD/show_criterion_indicators.html.twig'
                ))
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function postRemove($object)
    {
        $this->getConfigurationPool()->getContainer()->get('sonata.notification.backend')->createAndPublish('backend', array(
                'classification' => $object->getClassification()->getId(),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function postPersist($object)
    {
        $this->getConfigurationPool()->getContainer()->get('sonata.notification.backend')->createAndPublish('backend', array(
                'classification' => $object->getClassification()->getId(),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function postUpdate($object)
    {
        $this->getConfigurationPool()->getContainer()->get('sonata.notification.backend')->createAndPublish('backend', array(
                'classification' => $object->getClassification()->getId(),
            )
        );
    }
}
