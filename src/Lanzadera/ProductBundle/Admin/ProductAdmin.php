<?php

namespace Lanzadera\ProductBundle\Admin;

use Lanzadera\CoreBundle\Admin\Admin;
use Lanzadera\ProductBundle\Form\Extension\ChoiceList\StatusChoiceList;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductAdmin extends Admin
{
    protected $baseRouteName = "lanzadera_product";

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array(
                    'label' => 'product.name.label'
            ))
            ->add('description', null, array(
                    'label' => 'product.description.label'
            ))
            ->add('status', null, array(
                    'label' => 'product.status.label'
                ), 'status', array(
                    'constraints' => array()
                )
            )
            ->add('category', null, array(
                    'label' => 'product.category.label'
                ), null,
                array(
                    'expanded' => false,
                    'multiple' => true,
                    'query_builder' => $this->getRepository('taxon')->createTaxonQuery('Category'),
            ))
            ->add('tags', null, array(
                    'label' => 'product.tag.label'
                ), null,
                array(
                    'expanded' => false,
                    'multiple' => true,
                    'query_builder' => $this->getRepository('taxon')->createTaxonQuery('Tag'),
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array(
                    'label' => 'product.name.label'
            ))
            ->add('description', null, array(
                    'label' => 'product.description.label'
            ))
            ->addIdentifier('organization.name', null, array(
                    'label' => 'product.organization.label'
            ))
            ->add('category.name', null, array(
                    'label' => 'product.category.label'
            ))
            ->add('status', 'string', array(
                    'label' => 'product.status.label',
                    'template' => 'LanzaderaProductBundle:CRUD:list_status.html.twig'
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
            ->with('product.group.description', array('class' => 'col-md-6'))
                ->add('name', null, array(
                        'label' => 'product.name.label',
                        'required' => true,
                ))
                ->add('description', 'textarea', array(
                        'label' => 'product.description.label'
                ))
                ->add('status', 'status', array(
                        'label' => 'product.status.label'
                ))
                ->add('organization', null, array(
                        'label' => 'product.organization.label',
                        'required' => true,
                        'attr' => array(
                            'placeholder' => 'product.organization.placeholder',
                            'class' => 'form-control',
                        )
                ))
                ->add('category', 'sonata_type_model', array(
                        'label' => 'product.category.label',
                        'query' => $this->getRepository('taxon')->createTaxonQuery('Category'),
                        'btn_add' => false,
                        'required' => true,
                        'attr' => array(
                            'placeholder' => 'product.category.placeholder',
                            'class' => 'form-control'
                        )
                    ),
                    array(
                        'admin_code' => 'lanzadera.admin.category',
                    )
                )
                ->add('tags', 'sonata_type_model', array(
                        'label' => 'product.tag.label',
                        'query' => $this->getRepository('taxon')->createTaxonQuery('Tag'),
                        'expanded' => false,
                        'multiple' => true,
                        'btn_add' => 'product.tags.add',
                        'required' => false,
                        'attr' => array(
                            'placeholder' => 'product.tag.placeholder',
                            'class' => 'form-control'
                        )
                    ),
                    array(
                        'admin_code' => 'lanzadera.admin.tag'
                    )
                )
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
            ->with('product.group.indicators')
                ->add('indicators', 'product_indicator', array(
                    'label' => 'Indicadores',
                    'block_name' => 'lanzadera_indicator'
                ))
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array(
                    'label' => 'product.name.label'
            ))
            ->add('description', null, array(
                    'label' => 'product.description.label'
            ))
            ->add('category.name', null, array(
                    'label' => 'product.category.label'
            ))
            ->add('media', null, array(
                    'label' => 'product.media.label',
                    'template' => 'LanzaderaProductBundle:CRUD:media_status.html.twig'
                ))
            ->add('tags_as_list', null, array(
                    'label' => 'product.tag.label'
            ))
            ->add('status', 'string', array(
                    'label' => 'product.status.label',
                    'template' => 'LanzaderaProductBundle:CRUD:show_status.html.twig'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        $this->getConfigurationPool()->getContainer()->get('ladybug')->log($this->getForm()->getData());
    }


}
