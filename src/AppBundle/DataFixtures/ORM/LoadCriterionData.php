<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 26/08/14
 * Time: 17:57
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\DataFixture;
use AppBundle\Entity\Criterion;
use AppBundle\Entity\Indicator;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCriterionData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $criteria = array (
            array(
                "Indicador A",
                "Empresa",
                "CriterioA",
                array("Indicador A1" => 2, "Indicador A2" => 4, "Indicador A3" => 6, "Indicador A4" => 8),
            ),
            array(
                "Indicador B",
                "Producto",
                "CriterioA",
	            array("Indicador B1" => 2, "Indicador B2" => 4, "Indicador B3" => 6, "Indicador B4" => 8),
            ),
            array(
                "Indicador C",
                "Producto",
                "CriterioB",
	            array("Indicador C1" => 1, "Indicador C2" => 2, "Indicador C3" => 3, "Indicador C4" => 4),
            ),
            array(
                "Indicador D",
                "Producto",
                "CriterioB",
	            array("Indicador D1" => 2, "Indicador D2" => 4, "Indicador D3" => 6, "Indicador D4" => 8),
            ),
            array(
                "Indicador E",
                "Producto",
                "CriterioC",
	            array("Indicador E1" => 2, "Indicador E2" => 4, "Indicador E3" => 6, "Indicador E4" => 8),
            ),
            array(
                "Indicador F",
                "Producto",
                "CriterioC",
	            array("Indicador F1" => 2, "Indicador F2" => 8, "Indicador F3" => 12, "Indicador F4" => 16),
            ),
        );

        foreach ($criteria as $id => $criterion) {
            $manager->persist($this->createCriterion(
                $id,
                $criterion[0],
                $criterion[1],
                $criterion[2],
                $criterion[3]
            ));
        }

        $manager->flush();
    }

    private function createCriterion($id, $name, $type, $classification, $indicators)
    {
        $repo = $this->getCriterionRepository();
        $repoi = $this->getIndicatorRepository();
        /** @var Criterion $criterion */
        $criterion = $repo->createNew();

        $criterion->setName($name);
        $criterion->setDescription($this->faker->text);
        $criterion->setType($type == "Producto" ? Criterion::PRODUCT : Criterion::ORGANIZATION);
        $criterion->setClassification($this->getReference('Lanzadera.Classification.' . $classification));

        foreach ($indicators as $label => $value) {
            /** @var Indicator $indicator */
            $indicator = $repoi->createNew();

            $indicator->setName($label);
            $indicator->setValue($value);
            $criterion->addIndicator($indicator);
            $this->addReference('Lanzadera.Indicator.' . $label, $indicator);
        }

        $this->addReference('Lanzadera.Criterion.' . $id, $criterion);

        return $criterion;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 4;
    }
} 