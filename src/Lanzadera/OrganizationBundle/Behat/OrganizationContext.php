<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 21/08/14
 * Time: 10:57
 */

namespace Lanzadera\OrganizationBundle\Behat;


use Behat\Gherkin\Node\TableNode;
use Lanzadera\CoreBundle\Behat\DefaultContext;
use Lanzadera\OrganizationBundle\Entity\Organization;

class OrganizationContext extends DefaultContext
{
    /**
     * @Given existen las siguientes organizaciones:
     */
    public function createOrganizations(TableNode $tableNode)
    {
        $em = $this->getEntityManager();
        foreach ($tableNode->getHash() as $organizationHash) {
            /** @var Organization $organization */
            $organization = $this->getContainer()->get('lanzadera.repository.organization')->findOneByName($organizationHash['name']);
            if (!$organization) {
                $organization = new Organization();
            }
            $organization->setName($organizationHash['name']);
            @$organization->setAddress($organizationHash['address']);
            @$organization->setPhone($organizationHash['phone']);
            @$organization->setEmail($organizationHash['email']);
            @$organization->setWeb($organizationHash['web']);
            @$organization->setEnabled($organizationHash['enabled']);

            $em->persist($organization);
            $em->flush();
        }
    }
} 