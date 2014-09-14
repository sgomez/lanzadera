<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 09/09/14
 * Time: 00:13
 */

namespace Lanzadera\MediaBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Hateoas\HateoasBuilder;
use Lanzadera\MediaBundle\Entity\Media;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class MediaController
 * @package Lanzadera\MediaBundle\Controller
 */
class MediaController extends FOSRestController
{
    /**
     * Return one media
     *
     * @ApiDoc()
     *
     * @param Media $media
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getMediaAction(Media $media)
    {
        $hateos = HateoasBuilder::create()->build();

        $json = $hateos->serialize($media, 'json');

        $view = $this->view($json, 200);

        return $this->handleView($view);
    }
} 