<?php

namespace Lanzadera\ClassificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Classification
 *
 * @ORM\Table(name="classification")
 * @ORM\Entity(repositoryClass="Lanzadera\CoreBundle\Doctrine\ORM\ClassificationRepository")
 */
class Classification
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="classification.name.not_blank")
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=45, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="threshold", type="string", length=45, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Range(min="0", max="100")
     */
    private $threshold;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Lanzadera\ProductBundle\Entity\Product", mappedBy="classification")
     */
    private $product;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Criterion", mappedBy="classification", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $criteria;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
        $this->criteria = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Returns a string representation
     *
     * @return string Name
     */
    public function __toString()
    {
        return $this->getName();
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
     * @return Classification
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
     * @return Classification
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
     * Set threshold
     *
     * @param string $threshold
     * @return Classification
     */
    public function setThreshold($threshold)
    {
        $this->threshold = $threshold;

        return $this;
    }

    /**
     * Get threshold
     *
     * @return string 
     */
    public function getThreshold()
    {
        return $this->threshold;
    }

    /**
     * Add product
     *
     * @param \Lanzadera\ProductBundle\Entity\Product $product
     * @return Classification
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

    /**
     * Add criteria
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Criterion $criteria
     * @return Classification
     */
    public function addCriterium(\Lanzadera\ClassificationBundle\Entity\Criterion $criteria)
    {
        $this->criteria[] = $criteria;

        return $this;
    }

    /**
     * Remove criteria
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Criterion $criteria
     */
    public function removeCriterium(\Lanzadera\ClassificationBundle\Entity\Criterion $criteria)
    {
        $this->criteria->removeElement($criteria);
    }

    /**
     * Get criteria
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
}
