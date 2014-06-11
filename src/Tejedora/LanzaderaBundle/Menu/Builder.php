<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 10/06/14
 * Time: 15:33
 */

namespace Tejedora\LanzaderaBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Inicio', array('route' => 'homepage'));
        $menu->addChild('Salir', array('route' => 'fos_user_security_logout'));

        return $menu;
    }
} 