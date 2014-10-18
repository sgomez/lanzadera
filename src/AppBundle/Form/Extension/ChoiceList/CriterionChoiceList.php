<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 29/08/14
 * Time: 13:33
 */

namespace AppBundle\Form\Extension\ChoiceList;

use AppBundle\Entity\Criterion;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class CriterionChoiceList extends LazyChoiceList
{
    private $choices = array(
        Criterion::ORGANIZATION => 'label.organization',
        Criterion::PRODUCT      => 'label.product',
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