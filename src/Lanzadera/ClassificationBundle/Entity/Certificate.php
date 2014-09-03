<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 2/09/14
 * Time: 13:33
 */

namespace Lanzadera\ClassificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="certificate")
 * @ORM\Entity(repositoryClass="Lanzadera\CoreBundle\Doctrine\ORM\CertificateRepository")
 */
class Certificate
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="auto", type="boolean", nullable=false)
     * @Assert\Type(type="bool")
     */
    private $auto;

    /**
     * @var \Lanzadera\OrganizationBundle\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="Lanzadera\ProductBundle\Entity\Product", inversedBy="certificates", cascade={"all"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $product;

    /**
     * @var \Lanzadera\ClassificationBundle\Entity\Classification
     *
     * @ORM\ManyToOne(targetEntity="Lanzadera\ClassificationBundle\Entity\Classification", inversedBy="certificates", cascade={"all"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="classification_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $classification;

    /**
     * @return string
     */
    function __toString()
    {
        return $this->getClassification()->getName();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set auto
     *
     * @param boolean $auto
     * @return Certificate
     */
    public function setAuto($auto)
    {
        $this->auto = $auto;

        return $this;
    }

    /**
     * Get auto
     *
     * @return boolean 
     */
    public function getAuto()
    {
        return $this->auto;
    }

    /**
     * Set product
     *
     * @param \Lanzadera\ProductBundle\Entity\Product $product
     * @return Certificate
     */
    public function setProduct(\Lanzadera\ProductBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Lanzadera\ProductBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set classification
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Classification $classification
     * @return Certificate
     */
    public function setClassification(\Lanzadera\ClassificationBundle\Entity\Classification $classification = null)
    {
        $this->classification = $classification;

        return $this;
    }

    /**
     * Get classification
     *
     * @return \Lanzadera\ClassificationBundle\Entity\Classification 
     */
    public function getClassification()
    {
        return $this->classification;
    }
}
