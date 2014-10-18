<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 2/09/14
 * Time: 13:33
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Certificate
 *
 * @ORM\Table(name="certificate")
 * @ORM\Entity(repositoryClass="AppBundle\Doctrine\ORM\CertificateRepository")
 */
class Certificate
{
    /**
     * @var bool
     *
     * @ORM\Column(name="auto", type="boolean", nullable=false)
     * @Assert\Type(type="bool")
     */
    private $auto;

    /**
     * @var Product
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="certificates", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $product;

    /**
     * @var Classification
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Classification", inversedBy="certificates", cascade={"persist"})
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
     * @param Product $product
     * @return Certificate
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set classification
     *
     * @param Classification $classification
     * @return Certificate
     */
    public function setClassification(Classification $classification = null)
    {
        $this->classification = $classification;

        return $this;
    }

    /**
     * Get classification
     *
     * @return Classification
     */
    public function getClassification()
    {
        return $this->classification;
    }
}
