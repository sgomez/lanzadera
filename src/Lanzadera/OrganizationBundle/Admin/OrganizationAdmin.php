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
    protected $baseRouteName = "lanzadera_organization";

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'organization.name.label'))
            ->add('phone', null, array('label' => 'organization.phone.label'))
            ->add('email', null, array('label' => 'organization.email.label'))
            ->add('enabled', null, array('label' => 'organization.enabled.label', 'editable' => true))
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
                ->add('name', null, array('label' => 'organization.name.label'))
                ->add('address', 'textarea', array('label' => 'organization.address.label', 'required' => false))
                ->add('phone', null, array('label' => 'organization.phone.label'))
                ->add('email', 'email', array('label' => 'organization.email.label', 'required' => false))
                ->add('web', 'url', array('label' => 'organization.web.label', 'required' => false))
                ->add('enabled', 'checkbox', array('label' => 'organization.enabled.label', 'required' => false))
            ->end()
            ->with('organization.group.indicators', array('class' => 'col-md-6'))
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
            ->add('name', null, array('label' => 'organization.name.label'))
            ->add('address', null, array('label' => 'organization.address.label'))
            ->add('enabled', null, array('label' => 'organization.enabled.label'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array('label' => 'organization.name.label'))
            ->add('address', 'textarea', array('label' => 'organization.address.label'))
            ->add('phone', null, array('label' => 'organization.phone.label'))
            ->add('email', null, array('label' => 'organization.email.label'))
            ->add('web', 'url', array('label' => 'organization.web.label'))
            ->add('enabled', null, array('label' => 'organization.enabled.label'))
            ->add('created_at', 'date', array('label' => 'organization.created_at.label'))
        ;
    }

}