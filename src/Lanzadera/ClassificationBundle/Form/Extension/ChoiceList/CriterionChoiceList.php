<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 29/08/14
 * Time: 13:33
 */

namespace Lanzadera\ClassificationBundle\Form\Extension\ChoiceList;


use Lanzadera\ClassificationBundle\Entity\Criterion;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class CriterionChoiceList extends LazyChoiceList
{
    private $choices = array(
        Criterion::ORGANIZATION => 'lanzadera.criterion.type.organization',
        Criterion::PRODUCT      => 'lanzadera.criterion.type.product',
    );

    /**
     * Loads the choice list
     *
     * Should be implemented by child classes.
     *
     * @return ChoiceListInterface The loaded choice list
     */
    protected function loadChoiceList()
    {
        return new SimpleChoiceList($this->choices);
    }
} 