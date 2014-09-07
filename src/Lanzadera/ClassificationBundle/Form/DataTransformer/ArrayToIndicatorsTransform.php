<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 28/08/14
 * Time: 06:16
 */

namespace Lanzadera\ClassificationBundle\Form\DataTransformer;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Lanzadera\ClassificationBundle\Entity\Indicator;
use Symfony\Component\Form\DataTransformerInterface;

class ArrayToIndicatorsTransform implements DataTransformerInterface
{
    /**
     * @var ObjectManager $om
     */
    private $om;

    /**
     * Constructor
     *
     * @param ObjectManager $om
     */
    function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($indicators)
    {
        $selected = array();
        if ($indicators) {
            /** @var Indicator $indicator */
            foreach ($indicators as $indicator) {
                $selected['criterion-' . $indicator->getCriterion()->getId()] = $indicator->getId();
            }
        }
        return $selected;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($selected)
    {
        $indicators = new ArrayCollection();
        foreach ($selected as $id) {
            if ($id) {
                $indicators[] = $this->om->getRepository('LanzaderaClassificationBundle:Indicator')->findOneById($id);
            }
        }
        return $indicators;
    }
}