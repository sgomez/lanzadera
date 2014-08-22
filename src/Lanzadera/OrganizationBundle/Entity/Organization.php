<?php

namespace Lanzadera\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Organization
 *
 * @ORM\Table(name="organization")
 * @ORM\Entity(repositoryClass="Lanzadera\CoreBundle\Doctrine\ORM\OrganizationRepository")
 */
class Organization
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
     * @Assert\NotBlank(message = "organization.name.not_blank")
     * @Assert\Length(max="255", maxMessage="organization.name.max_message")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email()
     * @Assert\Length(max="255")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="web", type="string", length=255, nullable=true)
     * @Assert\Url()
     * @Assert\Length(max="255")
     */
    private $web;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     * @Assert\Type(type="bool")
     */
    private $enabled;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Assert\DateTime()
     */
    private $createdAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Lanzadera\ProductBundle\Entity\Product", mappedBy="organization", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $products;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Lanzadera\ClassificationBundle\Entity\Parameter", inversedBy="organization")
     * @ORM\JoinTable(name="organization_has_parameter",
     *   joinColumns={
     *     @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
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
        $this->parameter = new \Doctrine\Common\Collections\ArrayCollection();
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
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
     * Add parameter
     *
     * @param \Lanzadera\ClassificationBundle\Entity\Parameter $parameter
     * @return Organization
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
}
