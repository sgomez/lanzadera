<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 06:01
 */

namespace AppBundle\Behat;

use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\ClassificationBundle\Entity\Context;
use Application\Sonata\ClassificationBundle\Entity\Tag;
use Behat\Gherkin\Node\TableNode;

class TaxonomyContext extends DefaultContext
{
    /**
     * @Given existen las siguientes categorías:
     */
    public function createTaxons(TableNode $categoriesTable)
    {
        $manager = $this->getEntityManager();
        $context = $this->getDefaultContext();

        $baseCategory = new Category();
        $baseCategory->setName('Default');
        $baseCategory->setContext($context);
        $baseCategory->setEnabled(true);
        $manager->persist($baseCategory);

        foreach ($categoriesTable->getRows() as $node) {
            $categoryList = explode('>', $node[0]);
            /** @var Category $parent */
            $parent = $baseCategory;

            foreach ($categoryList as $categoryName) {
                $categoryName = trim($categoryName);

                /* @var $category Category */
                $category = $this->getRepository('category')->createNew();
                $category->setName($categoryName);
                $category->setDescription($this->faker->text);
                $category->setEnabled(true);
                $category->setContext($context);

                if (null !== $parent) {
                    $category->setParent($parent);
                }

                $parent = $category;

                $manager->persist($category);
            }
        }

        $manager->flush();
    }

    /**
     * @Given existen las siguientes etiquetas:
     */
    public function createTags(TableNode $tableNode)
    {
        $manager = $this->getEntityManager();
        $context = $this->getDefaultContext();

        foreach ($tableNode->getHash() as $tagHash) {
            /** @var Tag $tag */
            $tag = $this->getRepository('tag')->createNew();
            $tag->setName($tagHash['nombre']);
            $tag->setEnabled(true);
            $tag->setContext($context);

            $manager->persist($tag);
        }
        $manager->flush();
    }

    protected function getDefaultContext()
    {
        try {
            $context = $this->findOneByName( 'context', 'default' );
        } catch (\InvalidArgumentException $e) {
            $context = new Context();
            $context->setId('default');
            $context->setName('default');
            $context->setEnabled(true);
            $this->getEntityManager()->persist($context);
            $this->getEntityManager()->flush();
        }
        return $context;
    }
} 