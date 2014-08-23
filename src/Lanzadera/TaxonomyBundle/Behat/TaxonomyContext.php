<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 06:01
 */

namespace Lanzadera\TaxonomyBundle\Behat;


use Behat\Gherkin\Node\TableNode;
use Lanzadera\CoreBundle\Behat\DefaultContext;
use Lanzadera\TaxonomyBundle\Entity\Taxon;
use Lanzadera\TaxonomyBundle\Entity\Taxonomy;

class TaxonomyContext extends DefaultContext
{
    /**
     * @Given existen las siguientes categorías:
     */
    public function createCategories(TableNode $tableNode)
    {
        $em = $this->getEntityManager();
        foreach ($tableNode->getHash() as $categoryHash) {
            /** @var Taxon $parent */
            $parent = $this->getContainer()->get('sylius.repository.taxon')->findOneByName($categoryHash['superior']);
            /** @var Taxon $category */
            $category = $this->getContainer()->get('sylius.repository.taxon')->findOneByName($categoryHash['nombre']);
            if (!$category) {
                $category = new Taxon();
            }
            $category->setName($categoryHash['nombre']);
            $category->setDescription($categoryHash['descripción']);
            $category->setParent($parent);

            $em->persist($category);
            $em->flush();
        }
    }

    /**
     * @Given existen las siguientes etiquetas:
     */
    public function createTags(TableNode $tableNode)
    {
        $em = $this->getEntityManager();
        foreach ($tableNode->getHash() as $tagHash) {
            /** @var Taxonomy $tag */
            $tag = $this->getContainer()->get('sylius.repository.taxon')->findOneByName($tagHash['nombre']);
            if (!$tag) {
                $tag = new Taxonomy();
            }
            $tag->setName($tagHash['nombre']);

            $em->persist($tag);
            $em->flush();
        }
    }
} 