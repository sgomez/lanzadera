<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 06:01
 */

namespace AppBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Lanzadera\TaxonomyBundle\Entity\Taxonomy;

class TaxonomyContext extends DefaultContext
{
    /**
     * @Given existen las siguientes taxonomías:
     */
    public function createTaxonomies(TableNode $tableNode)
    {
        foreach($tableNode->getHash() as $node) {
            $taxonomy = $this->getRepository('taxonomy')->findOneByName($node['id']);

            if (!$taxonomy) {
                $taxonomy = new Taxonomy();
            }
            $taxonomy->setName($node['id']);
            $this->getEntityManager()->persist($taxonomy);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @Given /^la taxonomía "([^""]*)" tiene los siguientes elementos:$/
     */
    public function createTaxons($taxonomyName, TableNode $taxonsTable)
    {
        $taxonomy = $this->getRepository('taxonomy')->findOneByName($taxonomyName);
        $manager = $this->getEntityManager();

        $taxons = array();

        foreach ($taxonsTable->getRows() as $node) {
            $taxonList = explode('>', $node[0]);
            $parent = null;

            foreach ($taxonList as $taxonName) {
                $taxonName = trim($taxonName);

                if (!isset($taxons[$taxonName])) {
                    /* @var $taxon TaxonInterface */
                    $taxon = $this->getRepository('taxon')->createNew();
                    $taxon->setName($taxonName);

                    $taxons[$taxonName] = $taxon;
                }

                $taxon = $taxons[$taxonName];

                if (null !== $parent) {
                    $parent->addChild($taxon);
                } else {
                    $taxonomy->addTaxon($taxon);
                }

                $parent = $taxon;
            }
        }

        $manager->persist($taxonomy);
        $manager->flush();
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