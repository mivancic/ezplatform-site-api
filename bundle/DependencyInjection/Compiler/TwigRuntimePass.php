<?php

namespace Netgen\Bundle\EzPlatformSiteApiBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TwigRuntimePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('twig')) {
            return;
        }

        if ($container->has('twig.runtime_loader')) {
            // If official Twig runtime loader exists,
            // we skip using our custom runtime loader
            return;
        }

        $twig = $container->findDefinition('twig');

        $twig->addMethodCall(
            'addRuntimeLoader',
            [
                new Reference('netgen.ezplatform_site.twig.runtime_loader'),
            ]
        );
    }
}
