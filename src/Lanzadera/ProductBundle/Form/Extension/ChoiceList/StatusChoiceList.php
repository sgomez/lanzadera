<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 29/08/14
 * Time: 11:51
 */

namespace Lanzadera\ProductBundle\Form\Extension\ChoiceList;



use Lanzadera\ProductBundle\Entity\Product;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class StatusChoiceList extends LazyChoiceList
{
    private $choices = array(
        Product::STATUS_APPROVED  => 'lanzadera.product.status.approved',
        Product::STATUS_DENIED    => 'lanzadera.product.status.denied',
        Product::STATUS_PENDING   => 'lanzadera.product.status.pending',
        Product::STATUS_CHECK     => 'lanzadera.product.status.check',
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