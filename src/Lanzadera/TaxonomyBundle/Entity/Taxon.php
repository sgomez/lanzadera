<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 22/08/14
 * Time: 10:16
 */

namespace Lanzadera\TaxonomyBundle\Entity;

use Sylius\Bundle\TaxonomiesBundle\Model\Taxon as SyliusTaxon;
use Sylius\Bundle\TaxonomiesBundle\Model\TaxonInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Taxon
 * @package Lanzadera\ClassificationBundle\Entity
 * @ORM\MappedSuperclass()
 * @ORM\Entity(repositoryClass="Lanzadera\CoreBundle\Doctrine\ORM\TaxonRepository")
 */
class Taxon extends SyliusTaxon
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
        return str_repeat("—", $this->level) . $this->getName();
    }
}