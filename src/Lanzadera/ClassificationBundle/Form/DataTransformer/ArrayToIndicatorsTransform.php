<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 28/08/14
 * Time: 06:16
 */

namespace Lanzadera\ClassificationBundle\Form\DataTransformer;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectRepository;
use Lanzadera\ClassificationBundle\Entity\Indicator;
use Symfony\Component\Form\DataTransformerInterface;

class ArrayToIndicatorsTransform implements DataTransformerInterface
{
    /**
     * Indicator Repository
     *
     * @var ObjectRepository
     */
    private $indicatorRepository;

    public function __construct(ObjectRepository $indicatorRepository)
    {
        $this->indicatorRepository = $indicatorRepository;
    }

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

    public function reverseTransform($selected)
    {
        $indicators = new ArrayCollection();
        foreach ($selected as $id) {
            if ($id) {
                $indicators[] = $this->indicatorRepository->findOneById($id);
            }
        }
        return $indicators;
    }
}