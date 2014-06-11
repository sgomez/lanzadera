<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 10/06/14
 * Time: 17:14
 */

namespace Tejedora\LanzaderaBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class OrganizationAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'Nombre'))
            ->add('phone', 'text', array('label' => 'Teléfono'))
            ->add('email', 'text', array('label' => 'Correo electrónico'))
            ->add('website', 'text', array('label' => 'Página web'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('phone')
            ->add('email')
        ;
    }
} 