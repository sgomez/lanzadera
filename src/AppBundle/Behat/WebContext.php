<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 14/06/14
 * Time: 22:57
 */

namespace AppBundle\Behat;

class WebContext extends DefaultContext
{
    /**
     * @Given que estoy en la página del escritorio
     */
    public function iAmOnDashboard()
    {
        $this->getSession()->visit($this->generatePageUrl('sonata_admin_dashboard'));
    }

    /**
     * @Then debo estar en la página del escritorio
     * @Then debería estar en la página del escritorio
     */
    public function iShouldBeOnDashBoard()
    {
        $this->assertSession()->addressEquals($this->generatePageUrl('sonata_admin_dashboard'));
    }

    /**
     * @Given /^que estoy en la página (principal|creación) de (.*)$/
     */
    public function iAmOnActionResource($action, $resource)
    {
        $page = sprintf("lanzadera_%s_%s", $this->translate[$resource], $this->actions[$action]);
        $this->iAmOnPage($page);
    }

    /**
     * @Given /^que estoy en la página (mostrar|edición) de ([^"]*) con ([^"]*) "([^""]*)"$/
     */
    public function iAmDoingSomethingWithResource($action, $type, $property, $value)
    {
        $type = $this->translate[$type];
        $property = $this->translate[$property];

        $action = str_replace(array_keys($this->actions), array_values($this->actions), $action);
        $resource = $this->findOneBy($type, array($property => $value));

        $this->getSession()->visit($this->generatePageUrl(sprintf('lanzadera_%s_%s', $type, $action), array('id' => $resource->getId())));
    }


    /**
     * @Then /^debería estar en la página (mostrar|edición) de ([^"]*) con ([^"]*) "([^""]*)"$/
     */
    public function iShouldBeDoingSomethingWithResource($action, $type, $property, $value)
    {
        $type = $this->translate[$type];
        $property = $this->translate[$property];

        $action = str_replace(array_keys($this->actions), array_values($this->actions), $action);
        $resource = $this->findOneBy($type, array($property => $value));

        $this->assertSession()->addressEquals($this->generatePageUrl(sprintf('lanzadera_%s_%s', $type, $action), array('id' => $resource->getId())));
    }

    /**
     * @Then /^debería estar en la página (principal|creación) de (.*)$/
     * @Then /^debería estar todavía en la página (principal|creación) de (.*)$/
     */
    public function iShouldBeOnActionResource($action, $resource)
    {
        $page = sprintf("lanzadera_%s_%s", $this->translate[$resource], $this->actions[$action]);
        $this->iShouldBeOnPage($page);
    }


    /**
     * @Given estoy en la página :page
     */
    public function iAmOnPage($page)
    {
        $this->getSession()->visit($this->generatePageUrl($page));
    }

    /**
     * @Then /^debería estar en la página de ([^""]*) con ([^""]*) "([^""]*)"$/
     * @Then /^debería estar todavía en la página de ([^""]*) con ([^""]*) "([^""]*)"$/
     */
    public function iShouldBeOnTheResourcePage($type, $property, $value)
    {
        $type = $this->translate[$type];
        $property = $this->translate[$property];
        $resource = $this->findOneBy($type, array($property => $value));

        $this->assertSession()->addressEquals($this->generatePageUrl(sprintf('lanzadera_%s_show', $type), array('id' => $resource->getId())));
    }

    /**
     * @Then debería estar en la página :page
     */
    public function iShouldBeOnPage($page)
    {
        $this->assertSession()->addressEquals($this->generatePageUrl($page));
    }

    /**
     * @When presiono :button junto a :value
     */
    public function iClickNear($button, $value)
    {
        $tr = $this->assertSession()->elementExists('css', sprintf('table tbody tr:contains("%s")', $value));

        $locator = sprintf('button:contains("%s")', $button);

        if ($tr->has('css', $locator)) {
            $tr->find('css', $locator)->press();
        } else {
            $tr->clickLink($button);
        }
    }

    /**
     * @When /^presiono (.*) l.s (.*)$/
     */
    public function iClickActionOnBlock($action, $block)
    {
        $action = ucfirst($action);
        $block = ucfirst($block);
        $this->iClickNear($action, $block);

    }

    /**
     * @Then debería estar en la sección :block
     */
    public function deboEstarEnlaSeccion($block)
    {
        $this->assertSession()->elementExists('xpath', sprintf("//ol[contains(@class, 'breadcrumb')]//li[contains(@class, 'active')]//span[contains(text(),'%s')]", $block));
    }

    /**
     * @Then /^debería ver (\d+) (.*) en la lista$/
     */
    public function iShouldSeeNumItems($num)
    {
        $this->assertSession()->pageTextContains(sprintf("%d %s", $num, $num == 1 ? "resultado" : "resultados"));
    }
}