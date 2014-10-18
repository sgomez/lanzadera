<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 22/08/14
 * Time: 10:33
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Taxonomy\Model\Taxonomy as SyriusTaxonomy;
use Sylius\Component\Taxonomy\Model\TaxonomyInterface;

/**
 * Class Taxonomy
 * @package AppBundle\Entity
 * @ORM\MappedSuperclass()
 * @ORM\Entity(repositoryClass="AppBundle\Doctrine\ORM\TaxonomyRepository")
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