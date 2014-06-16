<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 22/04/14
 * Time: 16:41
 */

namespace Tejedora\LanzaderaBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Tejedora\LanzaderaBundle\Entity
 * @ORM\Entity(repositoryClass="Lanzadera\CoreBundle\Doctrine\ORM\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
} 