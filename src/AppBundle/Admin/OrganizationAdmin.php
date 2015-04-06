<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 10/06/14
 * Time: 17:14
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class OrganizationAdmin
 * @package AppBundle\Admin
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
                    'label' => 'label.name'
            ))
            ->add('createdAt', 'date', array(
                    'label' => 'label.created_at',
                    'pattern' => 'dd MMMM Y',
                    'locale' => 'es',
                    'timezone' => 'Europe/Madrid',
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
            ->with('group.organization_description', array('class' => 'col-md-6'))
                ->add('name', null, array(
                        'label' => 'label.name'
                ))
                ->add('description', 'textarea', array(
                        'label' => 'label.description',
                        'help' => 'help.description_organization',
                        'required' => false,
                ))
                ->add('address', 'textarea', array(
                        'label' => 'label.address',
                        'required' => false
                ))
                ->add('phone', null, array(
                        'label' => 'label.phone'
                ))
                ->add('email', 'email', array(
                        'label' => 'label.email',
                        'required' => false
                ))
                ->add('web', 'url', array(
                        'label' => 'label.web',
                        'required' => false
                ))
                ->add('enabled', 'checkbox', array(
                        'label' => 'label.enabled',
                        'required' => false,
                        'disabled' => false === $this->isGranted('ENABLED')
                ))
            ->end()
            ->with('group.image', array('class' => 'col-md-6'))
                ->add('media', 'sonata_media_type', array(
                    'label' => false,
                    'required' => false,
                    'provider' => 'sonata.media.provider.image',
                    'data_class'   =>  'Application\Sonata\MediaBundle\Entity\Media',
                    'context'  => 'default'
                ))
            ->end()
            ->with('group.organization_indicators', array('class' => 'col-md-12'))
                ->add('indicators', 'organization_indicator', array(
                    'label' => 'label.indicators',
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
                    'label' => 'label.name'
            ))
            ->add('address', null, array(
                    'label' => 'label.address'
            ))
            ->add('enabled', null, array(
                    'label' => 'label.enabled'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('group.organization_description', array('class' => 'col-md-6'))
                ->add('name', null, array(
                        'label' => 'label.name'
                ))
		        ->add('slug', null, array(
			        'label' => 'label.slug'
		        ))
		        ->add('description', null, array(
                        'label' => 'label.description',
                ))
                ->add('address', 'textarea', array(
                        'label' => 'label.address'
                ))
                ->add('phone', null, array(
                        'label' => 'label.phone'
                ))
                ->add('email', 'email', array(
                        'label' => 'label.email'
                ))
                ->add('web', 'url', array(
                        'label' => 'label.web'
                ))
                ->add('enabled', 'boolean', array(
                        'label' => 'label.enabled'
                ))
                ->add('created_at', 'date', array(
                        'label' => 'label.created_at'
                ))
            ->end()
            ->with('group.image', array('class' => 'col-md-6'))
                ->add('media', null, array(
                    'label' => ' ',
                    'template' => 'Organization/CRUD/show_media.html.twig',
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