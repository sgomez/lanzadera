<?php

namespace Lanzadera\ClassificationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * Criterion
 *
 * @ORM\Table(name="criterion", indexes={@ORM\Index(name="fk_criterion_classification1_idx", columns={"classification_id"})})
 * @ORM\Entity
 */
class Criterion
{
    const ORGANIZATION = 1;

    const PRODUCT = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @ORM\Column(name="type", type="string", length=45, nullable=true)
     */
    private $type;

    /**
     * @var \Classification
     *
     * @ORM\ManyToOne(targetEntity="Classification", inversedBy="criteria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="classification_id", referencedColumnName="id")
     * })
     */
    private $classification;

    /**
     * @var \Parameter
     *
     * @ORM\OneToMany(targetEntity="Parameter", mappedBy="criterion", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $parameters;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parameters = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Criterion
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
     * @return Criterion
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
     * @return Criterion
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
     * Set type
     *
     * @param string $type
     * @return Criterion
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set classification
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Classification $classification
     * @return Criterion
     */
    public function setClassification(\Lanzadera\ClassificationBundle\Entity\Classification $classification)
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

    public static function getTypes()
    {
        return array(
            self::ORGANIZATION => "Organization",
            self::PRODUCT => "Product",
        );
    }

    /**
     * Add parameters
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Parameter $parameter
     * @return Criterion
     */
    public function addParameter(\Lanzadera\ClassificationBundle\Entity\Parameter $parameter)
    {
        $parameter->setCriterion($this);
        $this->parameters[] = $parameter;

        return $this;
    }

    /**
     * Remove parameters
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Parameter $parameter
     */
    public function removeParameter(\Lanzadera\ClassificationBundle\Entity\Parameter $parameter)
    {
        $this->parameters->removeElement($parameter);
    }

    /**
     * Set parameters
     *
     * @param $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = new ArrayCollection();

        foreach($parameters as $parameter) {
            $this->addParameter($parameter);
        }
    }

    /**
     * Get parameters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
