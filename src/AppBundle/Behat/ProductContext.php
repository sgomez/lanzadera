<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 27/09/14
 * Time: 22:45
 */

namespace AppBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Lanzadera\ProductBundle\Entity\Product;

class ProductContext extends DefaultContext
{
    /**
     * @Given existen los siguientes productos:
     */
    public function createProducts(TableNode $tableNode)
    {
        $em = $this->getEntityManager();
        $status = Product::getStatuses();

        foreach ($tableNode->getHash() as $productHash) {
            /** @var Product $product */
            $product = $this->getRepository('product')->findOneByName($productHash['nombre']);
            if (!$product) {
                $product = new Product();
            }
            $product->setName($productHash['nombre']);
            $product->setDescription($this->faker->text);
            $product->setOrganization($this->getRepository('organization')->findOneByName($productHash['organización']));
            $product->setCategory($this->getRepository('category')->findOneByName($productHash['categoría']));
            $product->setStatus($status[array_rand($status)]);

            $tags = explode(",", $productHash['etiquetas']);
            foreach ($tags as $tag)
            {
                $product->addTag($this->getRepository('tag')->findOneByName(trim($tag)));
            }

            $em->persist($product);
            $em->flush();
        }
    }

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