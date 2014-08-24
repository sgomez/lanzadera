<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 22/08/14
 * Time: 10:33
 */

namespace Lanzadera\TaxonomyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Bundle\TaxonomiesBundle\Model\Taxonomy as SyriusTaxonomy;
use Sylius\Bundle\TaxonomiesBundle\Model\TaxonomyInterface;

/**
 * Class Taxonomy
 * @package Lanzadera\ClassificationBundle\Entity
 * @ORM\MappedSuperclass()
 * @ORM\Entity(repositoryClass="Lanzadera\CoreBundle\Doctrine\ORM\TaxonomyRepository")
 */
class Taxonomy extends SyriusTaxonomy implements TaxonomyInterface
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->setRoot(new Taxon());
    }
}