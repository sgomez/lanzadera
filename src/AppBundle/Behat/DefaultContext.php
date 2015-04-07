<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 14/06/14
 * Time: 20:14
 */

namespace AppBundle\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Faker\Factory as FakerFactory;
use Faker\Generator;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Bundle\ResourceBundle\Behat\DefaultContext as BaseDefaultContext;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class DefaultContext extends BaseDefaultContext
               implements Context, KernelAwareContext
{
    protected $actions = array(
        "principal" => "list",
        "creación"  => "create",
        "edición"   => "edit",
        "esquema"     => "tree",
    );

    protected $translate = array(
        "identificador" => "username",
        "nombre" => "name",

        "usuario" => "user",
        "organización" => "organization",
        "clasificación" => "classification",
        "criterio" => "criterion",
        "producto" => "product",
        "categoría" => "category",
        "etiqueta" => "tag"
    );

    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * Faker.
     *
     * @var Generator
     */
    protected $faker;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->faker = FakerFactory::create('es_ES');
    }

    /**
     * Get repository by resource name.
     *
     * @param string $resource
     *
     * @return RepositoryInterface
     */
    protected function getRepository($resource)
    {
        return $this->getService('lanzadera.repository.'.$resource);
    }

    /**
     * Generate page url.
     * This method uses simple convention where page argument is prefixed
     * with "lanzadera_" and used as route name passed to router generate method.
     *
     * @param object|string $page
     * @param array         $parameters
     *
     * @return string
     */
    protected function generatePageUrl($page, array $parameters = array())
    {
        if (is_object($page)) {
            return $this->locatePath($this->generateUrl($page, $parameters));
        }

        $route  = str_replace(' ', '_', trim($page));
        $routes = $this->getContainer()->get('router')->getRouteCollection();

        if (null === $routes->get($route)) {
            $route = 'lanzadera_'.$route;
        }

        if (null === $routes->get($route)) {
            $route = str_replace('lanzadera_', 'lanzadera_', $route);
        }

        $route = str_replace(array_keys($this->actions), array_values($this->actions), $route);
        $route = str_replace(' ', '_', $route);

        return $this->locatePath($this->generateUrl($route, $parameters));
    }

    /**
     * @param $type
     * @param $name
     * @param TableNode $tableNode
     *
     * @return mixed
     */
    protected function entityHasFollowingIndicator($type, $name, TableNode $tableNode)
    {
        $element = $this->getRepository($type)->findOneByName($name);

        foreach($tableNode->getHash() as $nodeHash) {
            $indicator = $this->getRepository('indicator')->findOneByCriterionAndName($nodeHash['criterio'], $nodeHash['indicador']);
            $element->addIndicator($indicator);
        }

        return $element;
    }

    /**
     * Take screenshot when step fails.
     * Works only with Selenium2Driver.
     *
     * @AfterStepScope
     */
    public function takeScreenshotAfterFailedStep(AfterStepScope $event)
    {
        if (99 === $event->getTestResult()->getResultCode()) {
            $driver = $this->getSession()->getDriver();
            if (!($driver instanceof Selenium2Driver)) {
                return;
            }
            $directory = 'build/behat/'.$event->getFeature()->getTitle().'.'.$event->getFeature()->getTitle();
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
            $filename = sprintf('%s_%s_%s.%s', $this->getMinkParameter('browser_name'), date('c'), uniqid('', true), 'png');
            file_put_contents($directory.'/'.$filename, $driver->getScreenshot());
        }
    }
} 