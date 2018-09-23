<?php

namespace Opera\TwigBlockBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Opera\TwigBlockBundle\DependencyInjection\Compiler\ResourceCompilerPass;

class OperaTwigBlockBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new ResourceCompilerPass());
    }
}
