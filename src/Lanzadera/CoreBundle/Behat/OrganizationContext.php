<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 27/09/14
 * Time: 22:39
 */

namespace Lanzadera\CoreBundle\Behat;


use Behat\Gherkin\Node\TableNode;

class OrganizationContext extends DefaultContext
{
	/**
	 * @Given /^la organización "([^".]*)" tiene los siguientes indicadores:$/
	 */
	public function organizationHasFollowingIndicator($name, TableNode $tableNode)
	{
		$em = $this->getEntityManager();
		$em->persist($this->entityHasFollowingIndicator('organization', $name, $tableNode));
		$em->flush();
	}
} 