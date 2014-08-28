<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 12:09
 */

namespace Lanzadera\FixtureBundle\DataFixtures\ORM;


use Doctrine\Common\Persistence\ObjectManager;
use Lanzadera\FixtureBundle\DataFixtures\DataFixture;
use Lanzadera\ProductBundle\Entity\Product;

class LoadProductsData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createProduct("Revolución", "Bebidas", "Barcelona"));
        $manager->persist($this->createProduct("Solidaridad", "Bebidas"));
        $manager->persist($this->createProduct("Justicia", "Alimentación"));
        $manager->persist($this->createProduct("Voluntario", "Ropa", "Francia"));
        $manager->persist($this->createProduct("Pobreza", "Ropa", "Córdoba", array("Alta calidad y bajo precio", "No perecedero")));

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 10;
    }

    private function createProduct($name, $category, $organization = "Córdoba", $indicators = array())
    {
        $repo = $this->getProductRepository();

        /** @var Product $product */
        $product = $repo->createNew();

        $product->setName($name);
        $product->setDescription($this->faker->text);
        $product->setCategory($this->getReference("Lanzadera.Category." . $category));
        $product->setOrganization($this->getReference("Lanzadera.Organization." . $organization));
        foreach($indicators as $indicator) {
            $product->addIndicator($this->getReference("Lanzadera.Indicator." . $indicator));
        }

        $this->setReference("Lanzadera.Product" . $name, $product);

        return $product;
    }
}