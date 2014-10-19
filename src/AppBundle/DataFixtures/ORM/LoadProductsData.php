<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 12:09
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\DataFixture;
use AppBundle\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProductsData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 30; $i ++) {
            $manager->persist($this->createProduct($i));
        }

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

    private function createProduct($index, $indicators = array())
    {
        $repo = $this->getProductRepository();
        $status = Product::getStatuses();

        /** @var Product $product */
        $product = $repo->createNew();

        $product->setName($this->faker->unique()->product);
        $product->setDescription($this->faker->text);
        $product->setCategory($this->getReference("Lanzadera.Category." . $this->faker->category));
        $product->setOrganization($this->getReference("Lanzadera.Organization." . $this->faker->numberBetween(0, 4)));
        $product->setStatus($status[array_rand($status)]);
	    $product->setRegularPrice($this->faker->optional()->randomNumber(2));
	    $product->setReducedPrice($this->faker->optional()->randomNumber(2));

        foreach($indicators as $indicator) {
            $product->addIndicator($this->getReference("Lanzadera.Indicator." . $indicator));
        }

        foreach(range(0, $this->faker->numberBetween(3,8)) as $i) {
            $product->addTag($this->getReference("Lanzadera.Tag." . $this->faker->unique($reset = $i === 0)->tag));
        }

        $product->setMedia($this->createImage($product->getName(), 'food'));

        $this->setReference("Lanzadera.Product" . $index, $product);

        return $product;
    }


}