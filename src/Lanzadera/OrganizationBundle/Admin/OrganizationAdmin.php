<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 10/06/14
 * Time: 17:14
 */

namespace Lanzadera\OrganizationBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class OrganizationAdmin
 * @package Tejedora\Lanzadera\CoreBundle\Admin
 */

class OrganizationAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = "lanzadera_organization";

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
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array(
                    'label' => 'organization.name.label'
            ))
            ->add('createdAt', 'date', array(
                    'label' => 'organization.created_at.label',
                    'pattern' => 'dd MMMM Y',
                    'locale' => 'es',
                    'timezone' => 'Europe/Madrid',
            ))
            ->add('_action', 'actions', array(
                    'label' => 'lanzadera.action',
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
            ->with('organization.group.description', array('class' => 'col-md-6'))
                ->add('name', null, array(
                        'label' => 'organization.name.label'
                ))
                ->add('description', 'textarea', array(
                        'label' => 'organization.description.label',
                        'help' => 'organization.description.help',
                        'required' => false,
                ))
                ->add('address', 'textarea', array(
                        'label' => 'organization.address.label',
                        'required' => false
                ))
                ->add('phone', null, array(
                        'label' => 'organization.phone.label'
                ))
                ->add('email', 'email', array(
                        'label' => 'organization.email.label',
                        'required' => false
                ))
                ->add('web', 'url', array(
                        'label' => 'organization.web.label',
                        'required' => false
                ))
                ->add('enabled', 'checkbox', array(
                        'label' => 'organization.enabled.label',
                        'required' => false,
                        'disabled' => false === $this->isGranted('ENABLED')
                ))
            ->end()
            ->with('product.group.image', array('class' => 'col-md-6'))
                ->add('media', 'sonata_media_type', array(
                    'label' => false,
                    'required' => false,
                    'provider' => 'sonata.media.provider.image',
                    'data_class'   =>  'Lanzadera\MediaBundle\Entity\Media',
                    'context'  => 'default'
                ))
            ->end()
            ->with('organization.group.indicators', array('class' => 'col-md-12'))
                ->add('indicators', 'organization_indicator', array(
                    'label' => 'Indicadores',
                ))
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array(
                    'label' => 'organization.name.label'
            ))
            ->add('address', null, array(
                    'label' => 'organization.address.label'
            ))
            ->add('enabled', null, array(
                    'label' => 'organization.enabled.label'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('organization.group.description', array('class' => 'col-md-6'))
                ->add('name', null, array(
                        'label' => 'organization.name.label'
                ))
		        ->add('slug', null, array(
			        'label' => 'organization.slug.label'
		        ))
		        ->add('description', null, array(
                        'label' => 'organization.description.label',
                ))
                ->add('address', 'textarea', array(
                        'label' => 'organization.address.label'
                ))
                ->add('phone', null, array(
                        'label' => 'organization.phone.label'
                ))
                ->add('email', 'email', array(
                        'label' => 'organization.email.label'
                ))
                ->add('web', 'url', array(
                        'label' => 'organization.web.label'
                ))
                ->add('enabled', 'boolean', array(
                        'label' => 'organization.enabled.label'
                ))
                ->add('created_at', 'date', array(
                        'label' => 'organization.created_at.label'
                ))
            ->end()
            ->with('product.group.image', array('class' => 'col-md-6'))
                ->add('media', null, array(
                    'label' => ' ',
                    'template' => 'LanzaderaOrganizationBundle:CRUD:show_media.html.twig',
                ))
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */    public function postPersist($object)
    {
        $this->getConfigurationPool()->getContainer()->get('sonata.notification.backend')->createAndPublish('backend', array(
                'classification' => 'all',
            )
        );
    }

    /**
     * {@inheritdoc}
     */    public function postUpdate($object)
    {
        $this->getConfigurationPool()->getContainer()->get('sonata.notification.backend')->createAndPublish('backend', array(
                'classification' => 'all',
            )
        );
    }
}