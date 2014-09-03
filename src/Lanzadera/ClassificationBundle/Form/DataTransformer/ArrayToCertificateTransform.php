<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 02/09/14
 * Time: 19:57
 */

namespace Lanzadera\ClassificationBundle\Form\DataTransformer;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Lanzadera\ClassificationBundle\Entity\Certificate;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\Request;

class ArrayToCertificateTransform implements DataTransformerInterface
{
    /**
     * @var ObjectManager $om
     */
    private $om;

    /**
     * @var Request $request
     */
    private $request;

    /**
     * @var mixed
     */
    private $subject;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    function __construct(ContainerInterface $container)
    {
        $this->om = $container->get('doctrine.orm.entity_manager');
        $this->request = $container->get('request');
        $this->subject = null;
    }

    /**
     * {@inheritdoc}
     */
    public function getProduct()
    {
        if ($this->subject === null && $this->request) {
            $id = $this->request->get('id');
            if (!preg_match('#^[0-9A-Fa-f]+$#', $id)) {
                $this->subject = false;
            } else {
                $this->subject = $this->om->getRepository('LanzaderaProductBundle:Product')->find($id);
            }
        }

        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($values)
    {
        $classifications = array();
        if ($values) {
            foreach ($values as $value) {
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
        // TODO - Reset lista
        $certificates = new ArrayCollection();

        if ($selected) {
            foreach($selected as $id) {
                $certificate = $this->om->getRepository('LanzaderaClassificationBundle:Certificate')
                    ->findOneBy(array('product' => $this->request->get('id'), 'classification' => $id));

                if (!$certificate) {
                    $certificate = new Certificate();
                }
                $certificate->setAuto(false);
                $certificate->setClassification($this->om->getRepository('LanzaderaClassificationBundle:Classification')->find($id));
                $certificate->setProduct($this->getProduct());
                $certificates[] = $certificate;
            }
        }

        return $certificates;
    }
}