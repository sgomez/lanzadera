<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;


/**
 * Criterion
 *
 * @ORM\Table(name="criterion", indexes={@ORM\Index(name="fk_criterion_classification1_idx", columns={"classification_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Doctrine\ORM\CriterionRepository")
 */
class Criterion
{
    const ORGANIZATION = 'organization';
    const PRODUCT = 'product';

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
     * @ORM\Column(name="name", type="string", length=128, nullable=false)
     * @Assert\NotBlank(message="criterion.name.not_blank")
     * @Assert\Length(max="128")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=45, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Choice(choices={"organization", "product"})
     */
    private $type;

    /**
     * @var \Classification
     *
     * @ORM\ManyToOne(targetEntity="Classification", inversedBy="criteria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="classification_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank()
     */
    private $classification;

    /**
     * @var \Indicator
     *
     * @ORM\OneToMany(targetEntity="Indicator", mappedBy="criterion", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $indicators;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->indicators = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get Criterion name
     *
     * @return string
     */
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
     * Get is a new entity
     *
     * @return bool
     */
    public function isNew()
    {
        return $this->id === null ? true : false;
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
     * @throws \InvalidArgumentException
     */
    public function setType($type)
    {
        if (!in_array($type, self::getTypes())) {
            throw new \InvalidArgumentException('Wrong criterion type supplied.');
        }

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
     * Get type values
     *
     * @return array
     */
    public static function getTypes()
    {
        return array(self::ORGANIZATION, self::PRODUCT);
    }

    /**
     * Set classification
     *
     * @param Classification $classification
     * @return Criterion
     */
    public function setClassification(Classification $classification)
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

    /**
     * Add indicators
     *
     * @param Indicator $indicator
     * @return Criterion
     */
    public function addIndicator(Indicator $indicator)
    {
        $indicator->setCriterion($this);
        $this->indicators[] = $indicator;

        return $this;
    }

    /**
     * Remove indicators
     *
     * @param Indicator $indicator
     */
    public function removeIndicator(Indicator $indicator)
    {
        $this->indicators->removeElement($indicator);
    }

    /**
     * Set indicators
     *
     * @param $indicators
     */
    public function setIndicators($indicators)
    {
        $this->indicators = new ArrayCollection();

        foreach($indicators as $indicator) {
            $this->addIndicator($indicator);
        }
    }

    /**
     * Get indicators
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicators($as_array = false)
    {
        if ($as_array) {
            $values = array();
            /** @var Indicator $indicator */
            foreach($this->indicators as $indicator) {
                $values[$indicator->getId()] = $indicator->getName();
            }
            return $values;
        }
        return $this->indicators;
    }
}
