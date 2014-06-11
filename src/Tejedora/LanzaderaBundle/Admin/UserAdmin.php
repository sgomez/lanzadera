<?php

namespace Tejedora\LanzaderaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends Admin
{
    protected $baseRouteName ="user_admin";

    protected $baseRoutePattern = "user";

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('roles')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('enabled', null, array('editable' => true))
            ->add('lastLogin')
            ->add('locked')
            ->add('roles', 'choice', array(
                'choices' => array(
                    'ROLE_SUPER_ADMIN' => 'Desarrollador',
                    'ROLE_ADMIN' => 'Administrador',
                    'ROLE_AUTHOR' => 'Autor',
                    'ROLE_USER' => 'Usuario',
                ),
                'expanded' => false,
                'multiple' => true,
                'required' => false
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
        $formMapper
            ->add('username')
            ->add('email')
            ->add('enabled', null, array('required' => false))
        ;
        $formMapper->add('roles', 'choice', array(
            'choices' => array(
                'ROLE_SUPER_ADMIN' => 'Desarrollador',
                'ROLE_ADMIN' => 'Administrador',
                'ROLE_AUTHOR' => 'Autor',
                'ROLE_USER' => 'Usuario',
            ),
            'expanded' => false,
            'multiple' => true,
            'required' => false
        ));
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('username')
            ->add('usernameCanonical')
            ->add('email')
            ->add('emailCanonical')
            ->add('enabled')
            ->add('salt')
            ->add('password')
            ->add('lastLogin')
            ->add('locked')
            ->add('expired')
            ->add('expiresAt')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('roles')
            ->add('credentialsExpired')
            ->add('credentialsExpireAt')
            ->add('id')
        ;
    }
}
