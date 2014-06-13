<?php

namespace Tejedora\LanzaderaBundle\Features\Context;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Definition\Call\When as StepWhen;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Driver\BrowserKitDriver;
use Behat\Mink\Exception\ExpectationException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Tejedora\LanzaderaBundle\Entity\User;

/**
 * Behat context class.
 */
class FeatureContext extends MinkContext
                     implements SnippetAcceptingContext, KernelAwareContext
{
    private $kernel;
    private $parameters;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    public function setKernel(KernelInterface $kernel)
    {
      $this->kernel = $kernel;
    }

    /**
     * Returns the Doctrine entity manager.
     *
     * @return Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->kernel->getContainer()->get("doctrine")->getManager();
    }

    /**
     * @Given /^que existen los siguientes usuarios:$/
     */
    public function generateUsers(TableNode $usersTable)
    {
        $em = $this->getEntityManager();
        foreach ($usersTable->getHash() as $userHash) {
            $user = $em->getRepository('LanzaderaBundle:User')->findOneByUsername($userHash['username']);
            if (!$user) {
                $user = new User();
            }
            $user->setUsername($userHash['username']);
            $user->setPlainPassword($userHash['password']);
            $user->setEmail($userHash['email']);
            $user->setEnabled($userHash['enabled']);
            $user->addRole($userHash['role']);

            $em->persist($user);
            $em->flush();
        }
    }

    /**
     * @Given que estoy autenticado como :username
     */
    public function authenticateUser($username)
    {
        $driver = $this->getSession()->getDriver();
        if (!$driver instanceof BrowserKitDriver) {
            throw new UnsupportedDriverActionException('Este paso solo está soportado con BrowserKitDriver', $driver);
        }

        $user = $this->kernel->getContainer()->get('fos_user.user_manager')->findUserByUsername($username);
        $firewall = $this->kernel->getContainer()->getParameter('fos_user.firewall_name');

        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());

        $session = $this->kernel->getContainer()->get('session');
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $this->getSession()->setCookie($session->getName(), $session->getId());

    }


    /**
     * @When presiono :link en el bloque :block
     */
    public function presionoEnElBloque($link, $block)
    {
        $node = $this->getSession()->getPage()->find('xpath', "//tr/td[contains(text(),'{$block}')]/..");
        $node->clickLink($link);
    }

    /**
     * @Then debo estar en la ruta :arg1
     */
    public function deboEstarEnLaRuta($arg1)
    {
        echo $this->getSession()->getCurrentUrl();
        throw new PendingException();
    }


}
