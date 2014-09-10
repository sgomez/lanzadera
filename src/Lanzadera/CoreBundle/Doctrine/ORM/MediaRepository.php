<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 2/09/14
 * Time: 8:45
 */

namespace Lanzadera\CoreBundle\Doctrine\ORM;


use Lanzadera\MediaBundle\Entity\Media;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MediaRepository extends CustomRepository
{
    public function generatePublicUrl($id)
    {
        /** @var Media $media */
        $media = $this->find($id);

        if (!$media) {
            throw new NotFoundHttpException();
        }

        return array("filename" => $media->getProviderReference());

    }
} 