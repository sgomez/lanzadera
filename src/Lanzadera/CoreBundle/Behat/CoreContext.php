<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 13:07
 */

namespace Lanzadera\CoreBundle\Behat;


use Behat\Gherkin\Node\TableNode;

use Lanzadera\CoreBundle\Entity\User;
use Symfony\Component\Intl\Exception\NotImplementedException;

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

//Y selecciono el indicador "Muy bajo" del criterio "Producción ecológica"
//Y debo ver el indicador "Muy bajo" en el criterio "Producción ecológica"

    /**
     * @Given /^selecciono el indicador "([^".]*)" del criterio "([^".]*)"$/
     */
    public function selectIndicatorInCriterion($indicator, $criterion)
    {
        file_put_contents('/tmp/out.html', $this->getSession()->getPage()->getOuterHtml());
        $select = $this->getSession()->getPage()->find('xpath', sprintf('//tr[contains(.,"%s")]//select', $criterion));
        $select->selectOption($indicator);
    }

    /**
     * @Then /^debo ver el indicador "([^".]*)" en el criterio "([^".]*)"$/
     */
    public function iShouldSeeIndicatorInCriterion($indicator, $criterion)
    {
        $this->assertSession()->elementExists('xpath', sprintf('//tr[contains(.,"%s")]//select/option[@selected="selected" and contains(.,"%s")]', $criterion, $indicator));
    }

    /**
     * @Given /^el producto "([^".]*)" tiene los siguientes indicadores:$/
     */
    public function productHasFollowingIndicator($name, TableNode $tableNode)
    {
        $em = $this->getEntityManager();
        $em->persist($this->entityHasFollowingIndicator('product', $name, $tableNode));
        $em->flush();
    }

    /**
     * @Given /^la organización "([^".]*)" tiene los siguientes indicadores:$/
     */
    public function organizationHasFollowingIndicator($name, TableNode $tableNode)
    {
        $em = $this->getEntityManager();
        $em->persist($this->entityHasFollowingIndicator('organization', $name, $tableNode));
        $em->flush();
    }

    protected function entityHasFollowingIndicator($type, $name, TableNode $tableNode)
    {
        $element = $this->getRepository($type)->findOneByName($name);

        foreach($tableNode->getHash() as $nodeHash) {
            $indicator = $this->getRepository('indicator')->findOneByCriterionAndName($nodeHash['criterio'], $nodeHash['indicador']);
            $element->addIndicator($indicator);
        }

        return $element;
    }
}