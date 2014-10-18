<?php

namespace Lanzadera\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Organization
 *
 * @ORM\Table(name="organization")
 * @ORM\Entity(repositoryClass="Lanzadera\CoreBundle\Doctrine\ORM\OrganizationRepository")
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "lanzadera_api_organization_show",
 *          parameters = { "slug" = "expr(object.getSlug())" },
 *          absolute = true
 *      )
 * )
 * @Hateoas\Relation(
 *      "media",
 *      href = @Hateoas\Route(
 *          "sonata_api_media_media_get_medium_binary",
 *          parameters = { "id" = "expr(object.getMedia().getId())", "format" = "default_big" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(excludeIf = "expr(object.getMedia() === null)")
 * )
 */
class Organization
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Exclude
     */
    private $id;

	/**
	 * @var string
	 *
	 * @Gedmo\Slug(fields={"name"})
	 * @ORM\Column(length=128, unique=true)
	 * @Serializer\XmlAttribute
	 */
	private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message = "organization.name.not_blank")
     * @Assert\Length(max="255", maxMessage="organization.name.max_message")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     * @Assert\Length(max="255")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     * @Serializer\Exclude
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     * @Serializer\Exclude
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email()
     * @Assert\Length(max="255")
     * @Serializer\Exclude
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="web", type="string", length=255, nullable=true)
     * @Assert\Url()
     * @Assert\Length(max="255")
     * @Serializer\Exclude
     */
    private $web;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     * @Assert\Type(type="bool")
     * @Serializer\Exclude
     */
    private $enabled;

	/**
	 * @var datetime $created
	 *
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(name="created_at", type="datetime")
	 * @Serializer\Exclude
	 */
	private $createdAt;

	/**
	 * @var datetime $updated
	 *
	 * @Gedmo\Timestampable(on="update")
	 * @ORM\Column(name="updated_at", type="datetime")
	 * @Serializer\Exclude
	 */
	private $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Lanzadera\ProductBundle\Entity\Product", mappedBy="organization", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Serializer\Exclude
     */
    private $products;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Indicator", inversedBy="organizations")
     * @ORM\JoinTable(name="organization_has_indicator",
     *   joinColumns={
     *     @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="indicator_id", referencedColumnName="id")
     *   }
     * )
     * @Serializer\Exclude
     */
    private $indicators;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"remove", "persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="media_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     * @Serializer\Exclude
     */
    private $media;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->indicators = new \Doctrine\Common\Collections\ArrayCollection();
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Return string object representation
     *
     * @return string
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
     * @return Organization
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
     * Set address
     *
     * @param string $address
     * @return Organization
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Organization
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Organization
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set web
     *
     * @param string $web
     * @return Organization
     */
    public function setWeb($web)
    {
        $this->web = $web;

        return $this;
    }

    /**
     * Get web
     *
     * @return string 
     */
    public function getWeb()
    {
        return $this->web;
    }

    public function getWebServerName()
    {
        return parse_url($this->web, PHP_URL_HOST);
    }

    /**
     * Set enabled
     *
     * @param string $enabled
     * @return Organization
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return string 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Check if the organization is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled ? true : false;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Organization
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add indicator
     *
     * @param \AppBundle\Entity\Indicator $indicator
     * @return Organization
     */
    public function addIndicator(\AppBundle\Entity\Indicator $indicator)
    {
        $this->indicators[] = $indicator;

        return $this;
    }

    /**
     * Remove indicator
     *
     * @param \AppBundle\Entity\Indicator $indicator
     */
    public function removeIndicator(\AppBundle\Entity\Indicator $indicator)
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
     * Add products
     *
     * @param \Lanzadera\ProductBundle\Entity\Product $products
     * @return Organization
     */
    public function addProduct(\Lanzadera\ProductBundle\Entity\Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \Lanzadera\ProductBundle\Entity\Product $products
     */
    public function removeProduct(\Lanzadera\ProductBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     * @return Organization
     */
    public function setMedia(\Application\Sonata\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Organization
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
     * Set slug
     *
     * @param string $slug
     * @return Organization
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Organization
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
