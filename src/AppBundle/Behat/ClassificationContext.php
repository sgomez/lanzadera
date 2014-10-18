<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 21/08/14
 * Time: 19:26
 */

namespace AppBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use AppBundle\Entity\Classification;
use AppBundle\Entity\Criterion;
use AppBundle\Entity\Indicator;

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
            $classification->setDescription($this->faker->text);
            $classification->setThreshold($classificationHash['umbral']);

            $em->persist($classification);
            $em->flush();
        }
    }

    /**
     * @Given existen los siguientes criterios:
     */
    public function createCriterion(TableNode $tableNode)
    {
        $em = $this->getEntityManager();
        foreach ($tableNode->getHash() as $criterionHash) {
            /** @var Classification $classification */
            $classification = $this->getContainer()->get('lanzadera.repository.classification')->findOneByName($criterionHash['clasificación']);
            /** @var Criterion $criterion */
            $criterion = $this->getContainer()->get('lanzadera.repository.criterion')->findOneByName($criterionHash['nombre']);
            if (!$criterion) {
                $criterion = new Criterion();
            }
            $criterion->setName($criterionHash['nombre']);
            $criterion->setDescription($this->faker->text);
            $criterion->setType($criterionHash['tipo'] === "Producto" ? Criterion::PRODUCT : Criterion::ORGANIZATION);
            $criterion->setClassification($classification);

            $em->persist($criterion);
            $em->flush();
        }
    }

    /**
     * @Given el criterio ":criterion" tiene los siguientes indicadores:
     */
    public function createIndicators($criterion, TableNode $tableNode)
    {
        $em = $this->getEntityManager();
        /** @var Criterion $criterion */
        $criterion = $this->getRepository('criterion')->findOneByName($criterion);
        foreach ($tableNode->getHash() as $hash) {
            /** @var Indicator $indicator */
            $indicator = $this->getRepository('indicator')->findOneBy(array('name' => $hash['nombre'], 'criterion' => $criterion));
            if (!$indicator) {
                $indicator = new Indicator();
            }
            $indicator->setName($hash['nombre']);
            $indicator->setValue($hash['valor']);
            $criterion->addIndicator($indicator);
        }
        $em->persist($criterion);
        $em->flush();
    }

    /**
     * @Then relleno un nuevo indicador ":name" con el valor ":value"
     */
    public function iFillNewIndicatorWithValue($name, $value)
    {
        $this->getSession()->wait(2000, '(0 === jQuery.active)');
        $input = $this->getSession()->getPage()->find('xpath', '//tr[last()]//input[@title="indicator_name_edit"]');
        $this->fillField($input->getAttribute('id'), $name);
        $input = $this->getSession()->getPage()->find('xpath', '//tr[last()]//input[@title="indicator_value_edit"]');
        $this->fillField($input->getAttribute('id'), $value);
    }

    /**
     * @Then debo ver el indicador ":name" con valor ":value"
     */
    public function iSeeIndicatorWithValue($name, $value)
    {
        $this->assertSession()->elementExists('xpath',
            sprintf('//tr[td[input[@value="%s"]]]//input[@value="%s"]', $name, $value
        ));
    }
}