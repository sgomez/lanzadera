<?php

namespace Lanzadera\CoreBundle\Behat;

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
use Lanzadera\CoreBundle\Entity\User;

/**
 * Behat context class.
 */
class UsersContext extends DefaultContext
{

    /**
     * @Given /^que existen los siguientes usuarios:$/
     */
    public function generateUsers(TableNode $usersTable)
    {
        $em = $this->getEntityManager();
        foreach ($usersTable->getHash() as $userHash) {
            $user = $this->getRepository('user')->findOneByUsername($userHash['username']);
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




}
