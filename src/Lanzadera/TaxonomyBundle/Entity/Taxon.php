<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 22/08/14
 * Time: 10:16
 */

namespace Lanzadera\TaxonomyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Bundle\TaxonomiesBundle\Model\Taxon as SyliusTaxon;
use Sylius\Bundle\TaxonomiesBundle\Model\TaxonInterface;

/**
 * Class Taxon
 * @package Lanzadera\ClassificationBundle\Entity
 * @ORM\MappedSuperclass()
 * @ORM\Entity(repositoryClass="Lanzadera\CoreBundle\Doctrine\ORM\TaxonRepository")
 */
class Taxon extends SyliusTaxon implements TaxonInterface
{
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