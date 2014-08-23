<?php

namespace Lanzadera\TaxonomyBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TaxonAdmin extends Admin
{
    protected $baseRouteName = "lanzadera_category";

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'left',
    );

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $query->andWhere(
            $query->expr()->isNull($query->getRootAlias() . '.taxonomy')
        );

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('description')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $filter = $this->getFilterParameters();
        $mainColumn = $filter['_sort_by'] == 'left' ? "tab_name" : "name";

        $listMapper
            ->addIdentifier($mainColumn, 'string', array(
                    'label' => 'Name',
                    'name' => 'name',
                    'sortable'=>true,
                    'sort_field_mapping'=> array('fieldName'=>'name'),
                    'sort_parent_association_mappings' => array(),
            ))
            ->add('description')
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
            ->add('name')
            ->add('description')
            ->add('parent', 'sonata_type_model', array(
                'query' => $this->getConfigurationPool()->getContainer()->get('lanzadera.repository.category')->createTaxonQuery(),
                'btn_add' => false,
                'required' => false,
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('slug')
            ->add('permalink')
            ->add('description')
        ;
    }
}
