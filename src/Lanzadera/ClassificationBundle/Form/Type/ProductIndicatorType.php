<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 28/08/14
 * Time: 22:04
 */

namespace Lanzadera\ClassificationBundle\Form\Type;


use Lanzadera\ClassificationBundle\Entity\Criterion;

class ProductIndicatorType extends IndicatorType
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return Criterion::PRODUCT;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'product_indicator';
    }
} 