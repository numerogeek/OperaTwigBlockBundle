<?php

namespace Opera\TwigBlockBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ResourceCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasParameter($parameter = 'twig.form.resources')) {
            $container->setParameter(
                $parameter,
                array_merge(
                    ['@OperaTwigBlock/form_theme.html.twig'],
                    $container->getParameter($parameter)
                )
            );
        }
    }
}
