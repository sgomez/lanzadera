<?php
/**
 * This file is part of the lanzadera package.
 * 
 * (c) Sergio Gómez
 * 
 * For the full copyright and licence information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lanzadera\CoreBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository as BaseEntityRepository;
use Lanzadera\CoreBundle\Repository\RepositoryInterface;


class CustomRepository extends BaseEntityRepository implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        $className = $this->getClassName();

        return new $className;
    }

} 