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
     * @ORM\Column(name="name", type="string", length=128, nullable=false)
     * @Assert\NotBlank(message="classification.name.not_blank")
     * @Assert\Length(max="128")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="threshold", type="integer", nullable=false)
     * @Assert\NotBlank()
     * @Assert\Range(min="0", max="100")
     */
    private $threshold;

    /**
     * @var string
     *
     * @ORM\Column(name="maximum", type="integer", nullable=false)
     */
    private $maximum;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Lanzadera\ClassificationBundle\Entity\Certificate", mappedBy="classification", cascade={"persist"})
     */
    private $certificates;

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
        $this->certificates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->criteria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->threshold = 0;
        $this->maximum = 0;
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

    public function getThresholdPoints()
    {
        return intval($this->maximum * $this->threshold / 100);
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

    /**
     * Set maximum
     *
     * @param integer $maximum
     * @return Classification
     */
    public function setMaximum($maximum)
    {
        $this->maximum = $maximum;

        return $this;
    }

    /**
     * Get maximum
     *
     * @return integer 
     */
    public function getMaximum()
    {
        return $this->maximum;
    }

    /**
     * Add certificates
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Certificate $certificates
     * @return Classification
     */
    public function addCertificate(\Lanzadera\ClassificationBundle\Entity\Certificate $certificates)
    {
        $certificates->setClassification($this);
        $this->certificates[] = $certificates;

        return $this;
    }

    /**
     * Remove certificates
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Certificate $certificates
     */
    public function removeCertificate(\Lanzadera\ClassificationBundle\Entity\Certificate $certificates)
    {
        $this->certificates->removeElement($certificates);
    }

    /**
     * Get certificates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCertificates()
    {
        return $this->certificates;
    }
}
