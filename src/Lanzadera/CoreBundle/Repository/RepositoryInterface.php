<?php
/**
 * This file is part of the lanzadera package.
 * 
 * (c) Sergio Gómez
 * 
 * For the full copyright and licence information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lanzadera\CoreBundle\Repository;


use Doctrine\Common\Persistence\ObjectRepository;

interface RepositoryInterface extends ObjectRepository
{
    /**
     * Create a new resource
     *
     * @return mixed
     */
    public function createNew();
} 