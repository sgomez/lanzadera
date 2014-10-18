<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 07/09/14
 * Time: 15:23
 */

namespace Lanzadera\FixtureBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Group;
use Lanzadera\FixtureBundle\DataFixtures\DataFixture;

class LoadGroupsData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createGroup('Administradores', array('ROLE_ADMIN')));
        $manager->persist($this->createGroup('Gestores', array('ROLE_STAFF')));
        $manager->persist($this->createGroup('Colaboradores', array('ROLE_OPER')));
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }

    public function createGroup($groupname, array $roles = array('ROLE_USER'))
    {
        $group = new Group($groupname, $roles);

        $this->addReference('Lanzadera.Group.' . $groupname, $group);

        return $group;
    }
} 