<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use FOS\UserBundle\Model\UserManagerInterface;

class UserAdmin extends Admin
{
    protected $baseRouteName = "lanzadera_user";

    /**
     * {@inheritdoc}
     */
    protected $datagridValues = array(
        '_page' => 1,            // display the first page (default = 1)
        '_sort_order' => 'ASC', // reverse order (default = 'ASC')
        '_sort_by' => 'username'  // name of the ordered field
    );

    /**
     * {@inheritdoc}
     */
    public function getFormBuilder()
    {
        $this->formOptions['data_class'] = $this->getClass();

        $options = $this->formOptions;
        $options['validation_groups'] = (!$this->getSubject() || is_null($this->getSubject()->getId())) ? 'Registration' : 'Profile';

        $formBuilder = $this->getFormContractor()->getFormBuilder( $this->getUniqid(), $options);

        $this->defineFormBuilder($formBuilder);

        return $formBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getExportFields()
    {
        // avoid security field to be exported
        return array_filter(parent::getExportFields(), function($v) {
            return !in_array($v, array('password', 'salt'));
        });
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('groups.name', null, array(
                'label' => 'Groups'
            ))
            ->add('enabled', null, array('editable' => true))
            ->add('_action', 'actions', array(
                'label' => 'Acciones',
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;

        $this->setTemplate('inner_list_row', 'LanzaderaCoreBundle:User:inner_list_row.html.twig');
        $this->setTemplate('base_list_field', 'SonataAdminBundle:CRUD:base_list_flat_field.html.twig');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('username')
            ->add('email')
            ->add('groups')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General')
                ->add('username')
                ->add('email')
            ->end()
            ->with('Groups')
                ->add('groups')
            ->end()
            ->with('Profile')
                ->add('firstname')
                ->add('lastname')
                ->add('phone')
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('class' => 'col-md-6'))
                ->add('firstname', null, array(
                        'required' => true
                ))
                ->add('lastname', null, array(
                        'required' => true
                ))
                ->add('username')
                ->add('email')
                ->add('plainPassword', 'text', array(
                        'required' => (!$this->getSubject() || is_null($this->getSubject()->getId()))
                ))
                ->add('groups', 'sonata_type_model', array(
                        'required' => false,
                        'expanded' => false,
                        'multiple' => true,
                        'btn_add' => false,
                        'attr' => array(
                            'placeholder' => 'product.certificates.placeholder',
                            'class' => 'form-control'
                        )
                ))
            ->end()
            ->with('Imagen', array('class' => 'col-md-6'))
                ->add('media', 'sonata_media_type', array(
                    'label' => false,
                    'required' => false,
                    'provider' => 'sonata.media.provider.image',
                    'data_class'   =>  'Application\Sonata\MediaBundle\Entity\Media',
                    'context'  => 'default'
                ))
            ->end()
        ;

        if ($this->getSubject() && !$this->getSubject()->hasRole('ROLE_SUPER_ADMIN')) {
            $formMapper
                ->with('Management', array('class' => 'col-md-6'))
                    ->add('realRoles', 'sonata_security_roles', array(
                        'label'    => 'form.label_roles',
                        'expanded' => true,
                        'multiple' => true,
                        'required' => false
                    ))
                    ->add('locked', null, array('required' => false))
                    ->add('expired', null, array('required' => false))
                    ->add('enabled', null, array('required' => false))
                    ->add('credentialsExpired', null, array('required' => false))
                ->end()
            ;
        }

    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($user)
    {
        $this->getUserManager()->updateCanonicalFields($user);
        $this->getUserManager()->updatePassword($user);
    }

    /**
     * @param UserManagerInterface $userManager
     */
    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @return UserManagerInterface
     */
    public function getUserManager()
    {
        return $this->userManager;
    }
}
