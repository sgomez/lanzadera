<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 22/08/14
 * Time: 10:33
 */

namespace Lanzadera\TaxonomyBundle\Entity;

use Sylius\Bundle\TaxonomiesBundle\Model\Taxonomy as SyriusTaxonomy;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Taxonomy
 * @package Lanzadera\ClassificationBundle\Entity
 * @ORM\MappedSuperclass()
 */
class Taxonomy extends SyriusTaxonomy
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->setRoot(new Taxon());
    }
}