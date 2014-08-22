<?php

namespace Lanzadera\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="fk_product_organization_idx", columns={"organization_id"})})
 * @ORM\Entity(repositoryClass="Lanzadera\CoreBundle\Doctrine\ORM\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="description", type="string", length=45, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=45, nullable=true)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="raw_material_source", type="string", length=45, nullable=true)
     */
    private $rawMaterialSource;

    /**
     * @var string
     *
     * @ORM\Column(name="processing_site", type="string", length=45, nullable=true)
     */
    private $processingSite;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=45, nullable=true)
     */
    private $state;

    /**
     * @var \Organization
     *
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="Lanzadera\OrganizationBundle\Entity\Organization", inversedBy="products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     * })
     */
    private $organization;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Lanzadera\ClassificationBundle\Entity\Classification", inversedBy="product")
     * @ORM\JoinTable(name="product_has_classification",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="classification_id", referencedColumnName="id")
     *   }
     * )
     */
    private $classification;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Lanzadera\ClassificationBundle\Entity\Parameter", inversedBy="product")
     * @ORM\JoinTable(name="product_has_parameter",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="parameter_id", referencedColumnName="id")
     *   }
     * )
     */
    private $parameter;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classification = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parameter = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set id
     *
     * @param integer $id
     * @return Product
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
     * @return Product
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
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return Product
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set rawMaterialSource
     *
     * @param string $rawMaterialSource
     * @return Product
     */
    public function setRawMaterialSource($rawMaterialSource)
    {
        $this->rawMaterialSource = $rawMaterialSource;

        return $this;
    }

    /**
     * Get rawMaterialSource
     *
     * @return string 
     */
    public function getRawMaterialSource()
    {
        return $this->rawMaterialSource;
    }

    /**
     * Set processingSite
     *
     * @param string $processingSite
     * @return Product
     */
    public function setProcessingSite($processingSite)
    {
        $this->processingSite = $processingSite;

        return $this;
    }

    /**
     * Get processingSite
     *
     * @return string 
     */
    public function getProcessingSite()
    {
        return $this->processingSite;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Product
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set organization
     *
     * @param \Lanzadera\OrganizationBundle\Entity\Organization $organization
     * @return Product
     */
    public function setOrganization(\Lanzadera\OrganizationBundle\Entity\Organization $organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization
     *
     * @return \Lanzadera\OrganizationBundle\Entity\Organization 
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Add classification
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Classification $classification
     * @return Product
     */
    public function addClassification(\Lanzadera\ClassificationBundle\Entity\Classification $classification)
    {
        $this->classification[] = $classification;

        return $this;
    }

    /**
     * Remove classification
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Classification $classification
     */
    public function removeClassification(\Lanzadera\ClassificationBundle\Entity\Classification $classification)
    {
        $this->classification->removeElement($classification);
    }

    /**
     * Get classification
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClassification()
    {
        return $this->classification;
    }

    /**
     * Add parameter
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Parameter $parameter
     * @return Product
     */
    public function addParameter(\Lanzadera\ClassificationBundle\Entity\Parameter $parameter)
    {
        $this->parameter[] = $parameter;

        return $this;
    }

    /**
     * Remove parameter
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Parameter $parameter
     */
    public function removeParameter(\Lanzadera\ClassificationBundle\Entity\Parameter $parameter)
    {
        $this->parameter->removeElement($parameter);
    }

    /**
     * Get parameter
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParameter()
    {
        return $this->parameter;
    }
}
