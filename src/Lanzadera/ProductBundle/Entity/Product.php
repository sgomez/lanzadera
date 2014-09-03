<?php

namespace Lanzadera\ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Lanzadera\ClassificationBundle\Entity\Certificate;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="fk_product_organization_idx", columns={"organization_id"})})
 * @ORM\Entity(repositoryClass="Lanzadera\CoreBundle\Doctrine\ORM\ProductRepository")
 */
class Product
{
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_CHECK = 'check';
    const STATUS_DENIED = 'denied';

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
     * @Assert\NotBlank(message="product.name.not_blank")
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
     * @ORM\Column(name="status", type="string", length=45, nullable=true)
     */
    private $status;

    /**
     * @var \Lanzadera\OrganizationBundle\Entity\Organization
     *
     * @ORM\ManyToOne(targetEntity="Lanzadera\OrganizationBundle\Entity\Organization", inversedBy="products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     * })
     */
    private $organization;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Lanzadera\ClassificationBundle\Entity\Certificate", mappedBy="product", cascade={"all"})
     */
    private $certificates;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Lanzadera\ClassificationBundle\Entity\Indicator", inversedBy="products")
     * @ORM\JoinTable(name="product_has_indicator",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="indicator_id", referencedColumnName="id")
     *   }
     * )
     */
    private $indicators;

    /**
     * @var \Lanzadera\TaxonomyBundle\Entity\Taxon
     *
     * @ORM\ManyToOne(targetEntity="Lanzadera\TaxonomyBundle\Entity\Taxon")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     * @Assert\Valid()
     */
    private $category;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Lanzadera\TaxonomyBundle\Entity\Taxon", cascade={"remove"})
     * @ORM\JoinTable(name="product_has_tag",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="taxon_id", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    private $tags;


    /**
     * @var \Lanzadera\MediaBundle\Entity\Media
     *
     * @ORM\OneToOne(targetEntity="Lanzadera\MediaBundle\Entity\Media", cascade={"remove", "persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     * })
     */
    private $media;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->certificates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicators = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->status = self::STATUS_PENDING;
    }

    /**
     * Get string object representation
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
     * @param string $status
     * @return Product
     * @throws \InvalidArgumentException
     */
    public function setStatus($status)
    {
        if (!in_array($status, self::getStatuses())) {
            throw new \InvalidArgumentException('Wrong status type supplied.');
        }

        $this->status = $status;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get all status values
     *
     * @return array
     */
    public static function getStatuses()
    {
        return array(self::STATUS_APPROVED, self::STATUS_CHECK, self::STATUS_DENIED, self::STATUS_PENDING);

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
     * Add indicator
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Indicator $indicator
     * @return Product
     */
    public function addIndicator(\Lanzadera\ClassificationBundle\Entity\Indicator $indicator)
    {
        $this->indicators[] = $indicator;

        return $this;
    }

    /**
     * Remove indicator
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Indicator $indicator
     */
    public function removeIndicator(\Lanzadera\ClassificationBundle\Entity\Indicator $indicator)
    {
        $this->indicators->removeElement($indicator);
    }

    /**
     * Get indicator
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicators()
    {
        return $this->indicators;
    }

    /**
     * Set indicators
     *
     * @param $indicators
     */
    public function setIndicators($indicators)
    {
        $this->indicators = new \Doctrine\Common\Collections\ArrayCollection();

        foreach($indicators as $indicator) {
            $this->addIndicator($indicator);
        }
    }

    /**
     * Set category
     *
     * @param \Lanzadera\TaxonomyBundle\Entity\Taxon $category
     * @return Product
     */
    public function setCategory(\Lanzadera\TaxonomyBundle\Entity\Taxon $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Lanzadera\TaxonomyBundle\Entity\Taxon 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add tags
     *
     * @param \Lanzadera\TaxonomyBundle\Entity\Taxon $tags
     * @return Product
     */
    public function addTag(\Lanzadera\TaxonomyBundle\Entity\Taxon $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Lanzadera\TaxonomyBundle\Entity\Taxon $tags
     */
    public function removeTag(\Lanzadera\TaxonomyBundle\Entity\Taxon $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function getTagsAsList()
    {
        return implode(", ", $this->tags->getValues());
    }

    /**
     * Set media
     *
     * @param \Lanzadera\MediaBundle\Entity\Media $media
     * @return Product
     */
    public function setMedia(\Lanzadera\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Lanzadera\MediaBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Add certificates
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Certificate $certificates
     * @return Product
     */
    public function addCertificate(\Lanzadera\ClassificationBundle\Entity\Certificate $certificates)
    {
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
     * Set certificates
     *
     * @param $certificates
     */
    public function setCertificates($certificates)
    {
        $this->certificates = new ArrayCollection();

        foreach($certificates as $certificate) {
            $this->addCertificate($certificate);
        }
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

    public function setClassifications($classifications)
    {
        $this->certificates = new ArrayCollection();
        foreach($classifications as $classification) {
            $certificate = new Certificate();

            $certificate->setAuto(false);
            $certificate->setProduct($this);
            $certificate->setClassification($classification);

            $this->addCertificate($certificate);
        }
    }
}
