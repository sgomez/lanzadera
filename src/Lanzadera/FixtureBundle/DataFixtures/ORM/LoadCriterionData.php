<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 26/08/14
 * Time: 17:57
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Criterion;
use AppBundle\Entity\Indicator;
use Lanzadera\FixtureBundle\DataFixtures\DataFixture;

class LoadCriterionData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $criteria = array (
            array(
                "Militancia en espacios sociales",
                "Empresa",
                "Sociales",
                array("Otros" => 2, "Organizaciones afines" => 4, "Redes de Consumo" => 6, "Mercaos sociales" => 8),
            ),
            array(
                "Fomenta el pensamiento críticos",
                "Producto",
                "Sociales",
                array("Fomento cultural" => 2, "Mensajes" => 4, "Comunicación" => 6, "Educativos" => 8),
            ),
            array(
                "Calidad/Precio",
                "Producto",
                "Comerciales",
                array("Alta calidad y precio" => 1, "Normal calidad y precio bajo" => 2,
                    "Normal calidad y bajo precio" => 3, "Alta calidad y bajo precio" => 4),
            ),
            array(
                "Requerimientos del producto",
                "Producto",
                "Comerciales",
                array("Perecedero" => 1, "Baja fecha de caducidad" => 2,
                    "Alta fecha de caducidad" => 3, "No perecedero" => 4),
            ),
            array(
                "Origen del producto",
                "Producto",
                "Ambientales",
                array("Extranjero" => 4, "España" => 8, "Andalucía" => 12, "Córdoba" => 16),
            ),
            array(
                "Producción ecológica",
                "Producto",
                "Ambientales",
                array("Baja" => 4, "Media" => 8, "Alta" => 12, "Muy alta" => 16),
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