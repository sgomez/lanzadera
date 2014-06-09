<?php

namespace Tejedora\LanzaderaBundle\Features\Context;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Definition\Call\When as StepWhen;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;
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
     * @Given /^estoy autenticado como administrador$/
     */
    public function estoyAutenticadoComoAdministrador()
    {
        return array(
            new StepWhen('estoy en "/login"', function(){}),
            new StepWhen('relleno "username" con "admin"', function(){}),
            new StepWhen('relleno "password" con "adminpw"', function(){}),
            new StepWhen('presiono "Entrar"', function(){}),
        );
    }

}
