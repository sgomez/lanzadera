<?php

namespace AppBundle\Admin;

use Doctrine\ORM\Query\Expr;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\ClassificationBundle\Admin\TagAdmin as BaseTagAdmin;

class TagAdmin extends BaseTagAdmin
{
    protected $baseRouteName = "lanzadera_tag";

    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);

        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected $datagridValues = array(
        '_page' => 1,            // display the first page (default = 1)
        '_sort_order' => 'ASC', // reverse order (default = 'ASC')
        '_sort_by' => 'name'  // name of the ordered field
    );
}
