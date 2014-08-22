<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 22/08/14
 * Time: 06:35
 */

namespace Lanzadera\ProductBundle\Behat;


use Behat\Gherkin\Node\TableNode;
use Lanzadera\CoreBundle\Behat\DefaultContext;
use Lanzadera\ProductBundle\Entity\Product;

class ProductContext extends DefaultContext
{
    /**
     * @Given existen los siguientes productos:
     */
    public function createOrganizations(TableNode $tableNode)
    {
        $em = $this->getEntityManager();
        foreach ($tableNode->getHash() as $productHash) {
            /** @var Organization $organization */
            $organization = $this->getContainer()->get('lanzadera.repository.organization')->findOneByName($productHash['organización']);
            /** @var Product $product */
            $product = $this->getContainer()->get('lanzadera.repository.product')->findOneByName($productHash['nombre']);
            if (!$product) {
                $product = new Product();
            }
            $product->setName($productHash['nombre']);
            $product->setDescription($productHash['descripción']);
            $product->setOrganization($organization);

            $em->persist($product);
            $em->flush();
        }
    }
} 