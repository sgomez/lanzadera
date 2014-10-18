<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 22/08/14
 * Time: 10:16
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Taxonomy\Model\Taxon as SyliusTaxon;
use Sylius\Component\Taxonomy\Model\TaxonInterface;


/**
 * Class Taxon
 * @package Lanzadera\ClassificationBundle\Entity
 * @ORM\MappedSuperclass()
 * @ORM\Entity(repositoryClass="AppBundle\Doctrine\ORM\TaxonRepository")
 */
class Taxon extends SyliusTaxon implements TaxonInterface
{

	/**
	* @var \Doctrine\Common\Collections\Collection
	*
	* @ORM\OneToMany(targetEntity="Lanzadera\ProductBundle\Entity\Product", mappedBy="category", cascade={"persist"})
    */
	protected $products;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
       parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getTabName();
    }

    /**
     * Get tabbed name
     *
     * @return string
     */
    public function getTabName()
    {
        return str_repeat("—", $this->level > 0 ? $this->level - 1 : 0) . " " . $this->getName();
    }
}