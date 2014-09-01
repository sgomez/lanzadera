<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 10:38
 */

namespace Lanzadera\FixtureBundle\DataFixtures\ORM;


use Doctrine\Common\Persistence\ObjectManager;
use Lanzadera\FixtureBundle\DataFixtures\DataFixture;
use Lanzadera\TaxonomyBundle\Entity\Taxon;
use Lanzadera\TaxonomyBundle\Entity\Taxonomy;

class LoadTaxonomyData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $categories = array();
        while(count($categories) < 10) {
            $categories[] = $this->faker->unique()->category;
        }
        $manager->persist($this->createTaxonomy("Category", $categories));
        $manager->persist($this->createTaxonomy("Tag", array("pantalón", "vino", "gluten")));

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

            $this->setReference("Lanzadera." . $name .".". $idx, $taxon);
        }

        $this->setReference("Lanzadera.Taxonomy." . $name, $taxonomy);

        return $taxonomy;
    }

} 