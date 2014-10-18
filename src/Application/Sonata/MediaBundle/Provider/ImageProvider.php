<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 30/08/14
 * Time: 07:21
 */

namespace Application\Sonata\MediaBundle\Provider;


use Symfony\Component\Form\FormBuilder;

class ImageProvider extends \Sonata\MediaBundle\Provider\ImageProvider
{
    public function buildMediaType(FormBuilder $formBuilder)
    {
        $formBuilder->add('binaryContent', 'file', array('label' => 'media.binary_content.label'));
    }

} 