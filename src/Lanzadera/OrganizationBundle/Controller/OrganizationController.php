<?php
/**
 * Created by PhpStorm.
 * Organization: sergio
 * Date: 08/09/14
 * Time: 16:30
 */

namespace Lanzadera\OrganizationBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\FOSRestBundle;
use FOS\RestBundle\View\View as FOSView;
use Nelmio\ApiDocBundle\Controller\ApiDocController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class OrganizationController
 * @package Lanzadera\OrganizationBundle\Controller
 */
class OrganizationController extends FOSRestController
{
    /**
     * Return all organizations
     *
     * @ApiDoc()
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getOrganizationsAction()
    {
        $data = $this->get('lanzadera.repository.organization')->findAllActives();

        $view = $this->view($data, 200);

        return $this->handleView($view);
    }

} 