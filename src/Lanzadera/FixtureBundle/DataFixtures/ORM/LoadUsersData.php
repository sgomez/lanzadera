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

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Doctrine\ORM\UserRepository;
use AppBundle\Entity\User;
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
        $user = $this->createUser("manager", "manager@test.uco.es", "managerpw", true);
        $user->addGroup($this->getReference('Lanzadera.Group.Administradores'));
        $manager->persist($user);
        $user = $this->createUser("staff", "staff@test.uco.es", "staffpw", true);
        $user->addGroup($this->getReference('Lanzadera.Group.Gestores'));
        $manager->persist($user);
        $user = $this->createUser("operator", "operator@test.uco.es", "operatorpw", true);
        $user->addGroup($this->getReference('Lanzadera.Group.Colaboradores'));
        $manager->persist($user);

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
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
        $user->setFirstname($this->faker->name);
        $user->setLastname($this->faker->lastName);
        $user->setMedia($this->createImage($username, 'cats'));

        return $user;
    }
}