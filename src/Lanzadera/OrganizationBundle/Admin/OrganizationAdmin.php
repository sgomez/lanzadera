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
            ->addIdentifier('name')
            ->add('phone')
            ->add('email')
            ->add('enabled', null, array('editable' => true))
            ->add('createdAt', 'date', array(
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
            ->with('General')
                ->add('name')
                ->add('address', 'textarea', array('required' => false))
                ->add('phone')
                ->add('email', 'email', array('required' => false))
                ->add('web', 'url', array('required' => false))
                ->add('enabled', 'checkbox', array('required' => false))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('address')
            ->add('enabled')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('address')
            ->add('phone')
            ->add('email', 'email')
            ->add('web', 'url')
            ->add('enabled')
            ->add('created_at', 'date')
        ;
    }

}