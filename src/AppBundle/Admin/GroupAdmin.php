<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 18/10/14
 * Time: 20:30
 */

namespace AppBundle\Admin;

use Sonata\UserBundle\Admin\Entity\GroupAdmin as BaseGroupAdmin;

class GroupAdmin extends BaseGroupAdmin
{
	/**
	 * {@inheritdoc}
	 */
	protected $baseRouteName = "lanzadera_group";

	/**
	 * {@inheritdoc}
	 */
	protected $baseRoutePattern = 'lanzadera/group';

} 