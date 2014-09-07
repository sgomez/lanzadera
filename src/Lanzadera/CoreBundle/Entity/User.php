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

    /**
     * @var \Lanzadera\MediaBundle\Entity\Media
     *
     * @ORM\OneToOne(targetEntity="Lanzadera\MediaBundle\Entity\Media", cascade={"remove", "persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="media_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    protected $media;

    /**
     * Set media
     *
     * @param \Lanzadera\MediaBundle\Entity\Media $media
     * @return User
     */
    public function setMedia(\Lanzadera\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Lanzadera\MediaBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }

}
