<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 28/08/14
 * Time: 22:10
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\Criterion;

class OrganizationIndicatorType extends IndicatorType
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return Criterion::ORGANIZATION;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'organization_indicator';
    }
} 