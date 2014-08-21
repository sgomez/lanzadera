<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 21/08/14
 * Time: 19:26
 */

namespace Lanzadera\ClassificationBundle\Behat;


use Behat\Gherkin\Node\TableNode;
use Lanzadera\ClassificationBundle\Entity\Classification;
use Lanzadera\CoreBundle\Behat\DefaultContext;

class ClassificationContext extends DefaultContext
{
    /**
     * @Given existen las siguientes clasificaciones:
     */
    public function createClassification(TableNode $tableNode)
    {
        $em = $this->getEntityManager();
        foreach ($tableNode->getHash() as $classificationHash) {
            /** @var Classification $classification */
            $classification = $this->getContainer()->get('lanzadera.repository.classification')->findOneByName($classificationHash['nombre']);
            if (!$classification) {
                $classification = new Classification();
            }
            $classification->setName($classificationHash['nombre']);
            $classification->setDescription($classificationHash['descripción']);
            $classification->setThreshold($classificationHash['umbral']);

            $em->persist($classification);
            $em->flush();
        }
    }
} 