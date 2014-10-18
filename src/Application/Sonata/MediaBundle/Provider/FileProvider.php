<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 30/08/14
 * Time: 06:58
 */

namespace Application\Sonata\MediaBundle\Provider;


use Symfony\Component\Form\FormBuilder;

class FileProvider extends \Sonata\MediaBundle\Provider\FileProvider
{
    public function buildMediaType(FormBuilder $formBuilder)
    {
        $formBuilder->add('binaryContent', 'file', array('label' => 'media.binary_content.label'));
    }
}