<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 23/08/14
 * Time: 19:40
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin as BaseAdmin;

class Admin extends BaseAdmin
{
    /**
     * Return service from container
     *
     * @param $repository
     * @return object
     */
    protected function getRepository($repository)
    {
        return $this->getConfigurationPool()->getContainer()->get('lanzadera.repository.' . $repository);
    }

    protected function getNotificationBackend()
    {
        return $this->getConfigurationPool()->getContainer()->get('sonata.notification.backend');
    }
}