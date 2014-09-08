<?php

namespace Lanzadera\TaxonomyBundle\Admin;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr;
use Lanzadera\CoreBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class TagAdmin extends Admin
{
    protected $baseRouteName = "lanzadera_tag";

    protected $baseRoutePattern = 'lanzadera/taxonomy/tag';

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
        $alias = $query->getRootAliases()[0];

        $query
            ->leftJoin($alias . '.taxonomy', 'y')
            ->where($query->expr()->eq('y.name', '?1'))
            ->andWhere($query->expr()->isNotNull($alias . '.parent'))
            ->setParameter('1', 'Tag')
        ;

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'tag.name.label'))
            ->add('description', null, array('label' => 'tag.description.label'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'tag.name.label'))
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
            ->add('name', null, array('label' => 'tag.name.label', 'attr' => array('title' => 'tag-name')))
            ->add('description', null, array('label' => 'tag.description.label'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array('label' => 'tag.name.label'))
            ->add('description', null, array('label' => 'tag.description.label'))
            ->add('parent.name', null, array('label' => 'tag.parent.label'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $taxonomy = $this->getRepository('taxonomy')->findOneByName('Tag');
        $object->setTaxonomy($taxonomy);
        $parent = $this->getRepository('taxon')->findOneBySlug('tag');
        $object->setParent($parent);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('name')
            ->assertNotBlank(array("message" => "tag.name.not_blank"))
            ->assertNotNull()
            ->end()
        ;
    }
}
