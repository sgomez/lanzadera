<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 10:38
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\DataFixture;
use AppBundle\Entity\Taxon;
use AppBundle\Entity\Taxonomy;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTaxonomyData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createTaxonomy("Category", $this->faker->allCategories));
        $manager->persist($this->createTaxonomy("Tag", $this->faker->allTags));
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 5;
    }

    private function createTaxonomy($name, $elements, $parent = null)
    {
        /** @var Taxonomy $taxonomy */
        $taxonomy = $this->getTaxonomyRepository()->createNew();

        $taxonomy->setName($name);

        foreach($elements as $idx => $element) {
            /** @var Taxon $taxon */
            $taxon = $this->getTaxonRepository()->createNew();
            $taxon->setName($element);
            $taxon->setDescription($this->faker->text);

            $taxonomy->addTaxon($taxon);

            $this->setReference(sprintf("Lanzadera.%s.%s", $name, $element), $taxon);
        }

        $this->setReference("Lanzadera.Taxonomy." . $name, $taxonomy);

        return $taxonomy;
    }

} 