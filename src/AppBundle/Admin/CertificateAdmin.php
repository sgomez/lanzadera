<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 02/09/14
 * Time: 17:40
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;

class CertificateAdmin extends Admin
{
	/**
	 * {@inheritdoc}
	 */
	protected $baseRouteName = "lanzadera_certificate";

	/**
	 * {@inheritdoc}
	 */
	protected $baseRoutePattern = 'lanzadera/certificate';

	/**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('classification', null, array(
                    'label' => 'label.classification',
                    'required' => true,
            ))
        ;
    }
} 