<?php
/**
 * Created by PhpStorm.
 * Organization: sergio
 * Date: 08/09/14
 * Time: 16:30
 */

namespace Lanzadera\OrganizationBundle\Controller;

use Hateoas\HateoasBuilder;
use Lanzadera\OrganizationBundle\Entity\Organization;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * Return one organization
     *
     * @ApiDoc()
     *
     * @param Organization $organization
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getOrganizationAction(Organization $organization)
    {
        $hateos = HateoasBuilder::create()->build();

        $json = $hateos->serialize($organization, 'json');

        return new Response($json);
    }
} 