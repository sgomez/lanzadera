<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 02/09/14
 * Time: 19:57
 */

namespace AppBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Certificate;
use Symfony\Component\Form\DataTransformerInterface;

class ArrayToCertificateTransform implements DataTransformerInterface
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
    public function transform($values)
    {
        $classifications = array();
        if ($values) {
            /** @var Certificate $value */
            foreach ($values as $value) {
                if (true === $value->getAuto()) continue;
                $classifications[] = $value->getClassification()->getId();
            }
        }
        return $classifications;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($selected)
    {
        $certificates = new ArrayCollection();

        if ($selected) {
            foreach($selected as $id) {
                $certificate = new Certificate();
                $certificate->setAuto(false);
                $certificate->setClassification($this->om->getRepository('AppBundle:Classification')->find($id));
                $certificates[] = $certificate;
            }
        }

        return $certificates;
    }
}