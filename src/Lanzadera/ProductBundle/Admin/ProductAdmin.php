<?php

namespace Lanzadera\ProductBundle\Admin;

use Doctrine\ORM\QueryBuilder;
use Lanzadera\CoreBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductAdmin extends Admin
{

    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = "lanzadera_product";

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
        $alias = current($query->getRootAliases());
        $query->leftJoin($alias . '.organization', 'o2');
        $query->leftJoin($alias . '.tags', 't');
        $query->leftJoin($alias . '.category', 'c');
        $query->leftJoin($alias . '.certificates', 'q');
        $query->leftJoin('q.classification', 'r');
        $query->addSelect('partial o2.{id, name, enabled}');
        $query->addSelect('t');
        $query->addSelect('c');
        $query->addSelect('q');
        $query->addSelect('partial r.{id, name}');
        return $query;
    }

    /**
     * {@inheritdoc}
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
            ->add('certificates.classification', null, array(
                    'label' => 'product.certificate.label'
                ), null,
                array(
                    'expanded' => false,
                    'multiple' => false,
            ))
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
            ->add('organization.name', null, array(
                    'label' => 'product.organization.label'
            ))
            ->add('certificates', null, array(
                    'label' => 'product.certificate.label'
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
                        'label' => 'product.status.label',
                        'help' => 'product.status.help',
                        'disabled' => false === $this->isGranted('STATUS')
                ))
                ->add('organization', null, array(
                        'label' => 'product.organization.label',
                        'help' => 'product.organization.help',
                        'required' => true,
                        'attr' => array(
                            'placeholder' => 'product.organization.placeholder',
                            'class' => 'form-control',
                        )
                ))
                ->add('regularPrice', 'money', array(
                        'label' => 'product.regular_price.label',
                        'required' => false,
                ))
                ->add('reducedPrice', 'money', array(
                        'label' => 'product.reduced_price.label',
                        'required' => false,
                ))
            ->end()
            ->with('product.group.metadata', array('class' => 'col-md-6'))
                 ->add('category', 'sonata_type_model', array(
                        'label' => 'product.category.label',
                        'help' => 'product.category.help',
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
                        'help' => 'product.tag.help',
                        'query' => $this->getRepository('taxon')->createTaxonQuery('Tag'),
                        'expanded' => false,
                        'multiple' => true,
                        'btn_add' => 'product.tag.add',
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
                ->add('autoCertificates', 'text', array(
                        'label' => 'product.certificates.auto.label',
                        'help' => 'product.certificates.auto.help',
                        'required' => false,
                        'disabled' => true,
                ))
                ->add('certificates', 'certificate', array(
                        'label' => 'product.certificates.label',
                        'help' => 'product.certificates.help',
                        'required' => false,
                        'attr' => array(
                            'placeholder' => 'product.certificates.placeholder',
                            'class' => 'form-control'
                      )
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
            ->with('product.group.indicators', array('class' => 'col-md-6'))
                ->add('indicators', 'product_indicator', array(
                    'label' => 'Indicadores',
                    'block_name' => 'lanzadera_indicator'
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
            ->with('product.group.description', array('class' => 'col-md-6'))
                ->add('name', null, array(
                        'label' => 'product.name.label'
                ))
	            ->add('slug', null, array(
		                'label' => 'product.slug.label'
	            ))
                ->add('description', null, array(
                        'label' => 'product.description.label'
                ))
                ->add('status', 'string', array(
                    'label' => 'product.status.label',
                    'template' => 'LanzaderaProductBundle:CRUD:show_status.html.twig'
                ))
                ->add('organization.name', null, array(
                    'label' => 'product.organization.label'
                ))
                ->add('category.name', null, array(
                        'label' => 'product.category.label'
                ))
                ->add('tags_as_list', null, array(
                        'label' => 'product.tag.label'
                ))
                ->add('certificates', 'collection', array(
                        'label' => 'product.certificate.label',
                ))
            ->end()
            ->with('product.group.image', array('class' => 'col-md-6'))
                ->add('media', null, array(
                    'label' => ' ',
                    'template' => 'LanzaderaProductBundle:CRUD:show_media.html.twig',
                ))
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function postPersist($object)
    {
        $this->getConfigurationPool()->getContainer()->get('sonata.notification.backend')->createAndPublish('backend', array(
                'classification' => 'all',
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function postUpdate($object)
    {
        $this->getConfigurationPool()->getContainer()->get('sonata.notification.backend')->createAndPublish('backend', array(
                'classification' => 'all',
            )
        );
    }
}
