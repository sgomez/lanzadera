<?php
/**
 * This file is part of the lanzadera package.
 * 
 * (c) Sergio Gómez
 * 
 * For the full copyright and licence information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lanzadera\FixtureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserInterface;
use Lanzadera\CoreBundle\Doctrine\ORM\UserRepository;
use Lanzadera\FixtureBundle\DataFixtures\DataFixture;


class LoadUsersData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = $this->createUser("admin", "admin@test.uco.es", "adminpw", true, array('ROLE_SUPER_ADMIN'));

        $manager->persist($user);

        for ($i=0; $i < 15; $i++) {
            $username = $this->faker->username;
            $user = $this->createUser(
                $username,
                $username."@test.uco.es",
                $username,
                $this->faker->boolean
            );

            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }

    public function createUser($username, $email, $password, $enabled = true, array $roles = array('ROLE_USER'))
    {
        /* @var $repo UserRepository */
        $repo = $this->getUserRepository();
        /* @var $user User */
        $user = $repo->createNew();

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEnabled($enabled);
        $user->setRoles($roles);
        $user->setPlainPassword($password);

        return $user;
    }
} 