<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 13:07
 */

namespace Lanzadera\CoreBundle\Behat;


use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Lanzadera\CoreBundle\Entity\User;
use Behat\Behat\Hook\Call\AfterStep;

class CoreContext extends DefaultContext
{
    /**
     * @Given /^que estoy autenticado como administrador$/
     */
    public function iAmLoggedInAsAdministrator()
    {
        $this->iAmLoggedInAsRole('ROLE_ADMIN');
    }


    /**
     * @Given /^espero que se (abra|cierre) la ventana$/
     */
    public function waitFor($sec)
    {
        sleep(2);
    }

    /**
     * Create an user if he doesn't exists.
     * @param $username
     * @param $password
     * @param null $role
     * @param string $enabled
     * @param null $address
     * @param array $groups
     * @param bool $flush
     * @return UserInterface
     */
    public function thereIsUser($username, $password, $role = null, $enabled = 'yes', $address = null, $groups = array(), $flush = true)
    {
        if (null === $user = $this->getRepository('user')->findOneBy(array('username' => $username))) {
            $addressData = explode(',', $address);
            $addressData = array_map('trim', $addressData);

            /** @var User $user */
            $user = $this->getRepository('user')->createNew();
            $user->setUsername($username);
            $user->setFirstname($this->faker->firstName);
            $user->setLastname($this->faker->lastName);
            $user->setFirstname(null === $address ? $this->faker->firstName : $addressData[0]);
            $user->setLastname(null === $address ? $this->faker->lastName : $addressData[1]);
            $user->setEmail($username . '@lanzadera.com');
            $user->setEnabled('yes' === $enabled);
            $user->setPlainPassword($password);

            if (null !== $address) {
                $user->setShippingAddress($this->createAddress($address));
            }

            if (null !== $role) {
                $user->addRole($role);
            }

            $this->getEntityManager()->persist($user);

            foreach ($groups as $groupName) {
                if ($group = $this->findOneByName('group', $groupName)) {
                    $user->addGroup($group);
                }
            }

            if ($flush) {
                $this->getEntityManager()->flush();
            }
        }

        return $user;
    }

    /**
     * Create user and login with given role.
     *
     * @param string $role
     * @param string $username
     */
    private function iAmLoggedInAsRole($role, $username = 'lanzadera')
    {
        $this->thereIsUser($username, 'lanzadera', $role);
        $this->getSession()->visit($this->generatePageUrl('fos_user_security_login'));

        $this->fillField('Usuario', $username);
        $this->fillField('Contraseña', 'lanzadera');
        $this->pressButton('Entrar');
    }

    /**
     * Take screenshot when step fails.
     * Works only with Selenium2Driver.
     *
     * @AfterStep
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