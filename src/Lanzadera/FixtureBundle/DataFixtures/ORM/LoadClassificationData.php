<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 20/08/14
 * Time: 07:41
 */

namespace Lanzadera\FixtureBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\Persistence\ObjectManager;
use Lanzadera\ClassificationBundle\Entity\Classification;
use Lanzadera\FixtureBundle\DataFixtures\DataFixture;

class LoadClassificationData extends DataFixture
{

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 15; $i++) {
            $organization = $this->createClassification(
                $this->faker->catchPhrase,
                $this->faker->text,
                $this->faker->numberBetween(50,80)
            );

            $manager->persist($organization);
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
        return 3;
    }

    private function createClassification($name, $description, $threshold)
    {
        $repo = $this->getClassificationRepository();
        /* @var $classification Classification */
        $classification = $repo->createNew();

        $classification->setName($name);
        $classification->setDescription($description);
        $classification->setThreshold($threshold);

        return $classification;
    }
}