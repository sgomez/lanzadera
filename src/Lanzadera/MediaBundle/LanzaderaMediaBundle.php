<?php

namespace Lanzadera\MediaBundle;

use Lanzadera\MediaBundle\DependencyInjection\Compiler\OverrideMediaGalleryCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LanzaderaMediaBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataMediaBundle';
    }
}
