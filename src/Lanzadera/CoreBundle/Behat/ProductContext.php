<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 27/09/14
 * Time: 22:45
 */

namespace Lanzadera\CoreBundle\Behat;


use Behat\Gherkin\Node\TableNode;

class ProductContext extends DefaultContext
{
	/**
	 * @Given /^el producto "([^".]*)" tiene los siguientes indicadores:$/
	 */
	public function productHasFollowingIndicator($name, TableNode $tableNode)
	{
		$em = $this->getEntityManager();
		$em->persist($this->entityHasFollowingIndicator('product', $name, $tableNode));
		$em->flush();
	}
} 