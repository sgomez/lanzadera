<?php

namespace AppBundle\Admin;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class CategoryAdmin extends Admin
{
    protected $baseRouteName = "lanzadera_category";

    protected $baseRoutePattern = 'lanzadera/taxonomy/category';

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'name',
    );

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);
        $alias = $query->getRootAliases()[0];

        $query
            ->leftJoin($alias . '.taxonomy', 'y')
            ->where($query->expr()->eq('y.name', '?1'))
            ->andWhere($query->expr()->isNotNull($alias . '.parent'))
            ->setParameter('1', 'Category')
        ;

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'label.name'))
            ->add('description', null, array('label' => 'label.description'))
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
                    'label' => 'label.categories',
                    'name' => 'name',
                    'sortable'=>true,
                    'sort_field_mapping'=> array('fieldName'=>'name'),
                    'sort_parent_association_mappings' => array(),
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
            ->add('name', null, array('label' => 'label.name'))
            ->add('description', null, array('label' => 'label.description'))
            ->add('parent', 'sonata_type_model',
                    array(
                        'label' => 'label.parent',
                        'query' => $this->getRepository('taxon')->createTaxonQuery('Category'),
                        'btn_add' => false,
                        'required' => false,
                        'attr' => array('placeholder' => 'label.category.placeholder', 'class' => 'form-control')
                    ),
                    array(
                        'admin_code' => 'lanzadera.admin.category',
                    )
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array('label' => 'label.name'))
            ->add('description', null, array('label' => 'label.description'))
            ->add('parent.name', null, array('label' => 'label.parent'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $taxonomy = $this->getRepository('taxonomy')->findOneByName('Category');
        if (!$object->getParent()) {
            $parent = $this->getRepository('taxon')->findOneBySlug('category');
            $object->setParent($parent);
        }
        $object->setTaxonomy($taxonomy);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('name')
            ->assertNotBlank(array("message" => "category.name.not_blank"))
            ->assertNotNull()
            ->end()
        ;
    }
}
