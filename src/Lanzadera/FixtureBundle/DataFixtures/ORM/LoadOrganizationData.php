<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 20/08/14
 * Time: 04:35
 */

namespace Lanzadera\FixtureBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserInterface;
use Lanzadera\CoreBundle\Doctrine\ORM\UserRepository;
use Lanzadera\FixtureBundle\DataFixtures\DataFixture;

class LoadOrganizationData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $names = array("Asturias", "Barcelona", "Córdoba", "Dinamarca", "España", "Francia", "Gerona", "Huesca");
        foreach ($names as $name) {
            $organization = $this->createOrganization(
                $name,
                $this->faker->address,
                $this->faker->email,
                $this->faker->phoneNumber,
                $this->faker->url,
                $this->faker->boolean
            );

            $manager->persist($organization);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    public function createOrganization($name, $address = "", $email = "", $phone = "", $web = "", $enabled = true)
    {
        /* @var $repo OrganizationRepository */
        $repo = $this->getOrganizationRepository();
        /* @var $organization Organization */
        $organization = $repo->createNew();

        $organization->setName($name);
        $organization->setAddress($address);
        $organization->setEmail($email);
        $organization->setPhone($phone);
        $organization->setWeb($web);
        $organization->setEnabled($enabled);
        $organization->setCreatedAt(new \DateTime());

        $this->addReference("Lanzadera.Organization." . $name, $organization);

        return $organization;
    }
} 