<?php

namespace Lanzadera\ClassificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lanzadera\ProductBundle\Entity\Product;
use Lanzadera\OrganizationBundle\Entity\Organization;

/**
 * Parameter
 *
 * @ORM\Table(name="parameter", indexes={@ORM\Index(name="fk_parameter_criterion1_idx", columns={"criterion_id"})})
 * @ORM\Entity
 */
class Parameter
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=45, nullable=true)
     */
    private $value;

    /**
     * @var \Criterion
     *
     * @ORM\ManyToOne(targetEntity="Criterion", inversedBy="parameters")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="criterion_id", referencedColumnName="id")
     * })
     */
    private $criterion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Lanzadera\OrganizationBundle\Entity\Organization", mappedBy="parameter")
     */
    private $organization;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Lanzadera\ProductBundle\Entity\Product", mappedBy="parameter")
     */
    private $product;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->organization = new \Doctrine\Common\Collections\ArrayCollection();
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Parameter
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set name
     *
     * @param string $name
     * @return Parameter
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Parameter
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set criterion
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Criterion $criterion
     * @return Parameter
     */
    public function setCriterion(\Lanzadera\ClassificationBundle\Entity\Criterion $criterion)
    {
        $this->criterion = $criterion;

        return $this;
    }

    /**
     * Get criterion
     *
     * @return \Lanzadera\ClassificationBundle\Entity\Criterion 
     */
    public function getCriterion()
    {
        return $this->criterion;
    }

    /**
     * Add organization
     *
     * @param \Lanzadera\OrganizationBundle\Entity\Organization $organization
     * @return Parameter
     */
    public function addOrganization(\Lanzadera\OrganizationBundle\Entity\Organization $organization)
    {
        $this->organization[] = $organization;

        return $this;
    }

    /**
     * Remove organization
     *
     * @param \Lanzadera\OrganizationBundle\Entity\Organization $organization
     */
    public function removeOrganization(\Lanzadera\OrganizationBundle\Entity\Organization $organization)
    {
        $this->organization->removeElement($organization);
    }

    /**
     * Get organization
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Add product
     *
     * @param \Lanzadera\ProductBundle\Entity\Product $product
     * @return Parameter
     */
    public function addProduct(\Lanzadera\ProductBundle\Entity\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \Lanzadera\ProductBundle\Entity\Product $product
     */
    public function removeProduct(\Lanzadera\ProductBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduct()
    {
        return $this->product;
    }
}
