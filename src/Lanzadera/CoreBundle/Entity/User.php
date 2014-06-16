<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 16/06/14
 * Time: 17:35
 */

namespace Lanzadera\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;

/**
 * @ORM\Entity(repositoryClass="Lanzadera\CoreBundle\Doctrine\ORM\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
} 