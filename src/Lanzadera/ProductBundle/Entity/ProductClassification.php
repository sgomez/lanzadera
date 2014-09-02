<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 2/09/14
 * Time: 13:33
 */

namespace Lanzadera\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product_classification")
 * @ORM\Entity(repositoryClass="Lanzadera\CoreBundle\Doctrine\ORM\ProductClassificationRepository")
 */
class ProductClassification
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
     * @ORM\ManyToOne(targetEntity="Lanzadera\ProductBundle\Entity\Product", inversedBy="classifications2")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var \Lanzadera\ClassificationBundle\Entity\Classification
     *
     * @ORM\ManyToOne(targetEntity="Lanzadera\ClassificationBundle\Entity\Classification", inversedBy="products2")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     * })
     */
    private $organization;


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
     * @return ProductClassification
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
     * @return ProductClassification
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
     * Set organization
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Classification $organization
     * @return ProductClassification
     */
    public function setOrganization(\Lanzadera\ClassificationBundle\Entity\Classification $organization = null)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization
     *
     * @return \Lanzadera\ClassificationBundle\Entity\Classification 
     */
    public function getOrganization()
    {
        return $this->organization;
    }
}
