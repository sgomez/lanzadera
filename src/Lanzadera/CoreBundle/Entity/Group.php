<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 16/06/14
 * Time: 17:37
 */

namespace Lanzadera\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseGroup;

/**
 * @ORM\Entity(repositoryClass="Lanzadera\CoreBundle\Doctrine\ORM\GroupRepository")
 * @ORM\Table(name="fos_group")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
} 