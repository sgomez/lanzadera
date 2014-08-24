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
use Lanzadera\TaxonomyBundle\Entity\Taxon;

class ProductContext extends DefaultContext
{
    /**
     * @Given existen los siguientes productos:
     */
    public function createProducts(TableNode $tableNode)
    {
        $em = $this->getEntityManager();
        foreach ($tableNode->getHash() as $productHash) {
            /** @var Product $product */
            $product = $this->getRepository('product')->findOneByName($productHash['nombre']);
            if (!$product) {
                $product = new Product();
            }
            $product->setName($productHash['nombre']);
            $product->setDescription($productHash['descripción']);
            $product->setOrganization($this->getRepository('organization')->findOneByName($productHash['organización']));
            $product->setCategory($this->getRepository('category')->findOneByName($productHash['categoría']));

            $tags = explode(",", $productHash['etiquetas']);
            foreach ($tags as $tag)
            {
                $product->addTag($this->getRepository('tag')->findOneByName(trim($tag)));
            }

            $em->persist($product);
            $em->flush();
        }
    }
} 