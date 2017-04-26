<?php

namespace KRG\MessageBundle;

use KRG\MessageBundle\DependencyInjection\Compiler\MessageCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KRGMessageBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new MessageCompilerPass());
    }
}
