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
use Lanzadera\MediaBundle\Entity\Media;
use Lanzadera\ProductBundle\Entity\Product;

class LoadProductsData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createProduct("Revolución"));
        $manager->persist($this->createProduct("Solidaridad"));
        $manager->persist($this->createProduct("Justicia"));
        $manager->persist($this->createProduct("Voluntario"));
        $manager->persist($this->createProduct("Pobreza", array("Alta calidad y bajo precio", "No perecedero")));

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

    private function createProduct($name, $indicators = array())
    {
        $repo = $this->getProductRepository();

        /** @var Product $product */
        $product = $repo->createNew();

        $product->setName($this->faker->product);
        $product->setDescription($this->faker->text);
        $product->setCategory($this->getReference("Lanzadera.Category." . $this->faker->category));
        $product->setOrganization($this->getReference("Lanzadera.Organization." . $this->faker->numberBetween(0, 4)));
        foreach($indicators as $indicator) {
            $product->addIndicator($this->getReference("Lanzadera.Indicator." . $indicator));
        }
        foreach(range(0, $this->faker->numberBetween(3,8)) as $i) {
            $product->addTag($this->getReference("Lanzadera.Tag." . $this->faker->unique($reset = $i === 0)->tag));
        }
        $product->setMedia($this->createImage($name));

        $this->setReference("Lanzadera.Product" . $name, $product);

        return $product;
    }

    private function createImage($name)
    {
        $repo = $this->getMediaRepository();
        $temp = tempnam('/tmp', 'lanzadera');
        file_put_contents($temp, file_get_contents('http://lorempixel.com/400/400/food/'));

        /** @var Media $image */
        $image = $repo->createNew();
        $image->setBinaryContent($temp);
        $image->setProviderName('sonata.media.provider.image');
        $image->setContext('default');
        $image->setName($name);

        return $image;
    }
}