<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 29/08/14
 * Time: 11:51
 */

namespace AppBundle\Form\Extension\ChoiceList;

use AppBundle\Entity\Product;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class StatusChoiceList extends LazyChoiceList
{
    private $choices = array(
        Product::STATUS_APPROVED  => 'status.approved',
        Product::STATUS_DENIED    => 'status.denied',
        Product::STATUS_PENDING   => 'status.pending',
        Product::STATUS_CHECK     => 'status.check',
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