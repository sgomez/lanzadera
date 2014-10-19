<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 2/09/14
 * Time: 8:45
 */

namespace AppBundle\Doctrine\ORM;

use Application\Sonata\MediaBundle\Entity\Media;
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