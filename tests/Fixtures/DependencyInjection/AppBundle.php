<?php declare(strict_types=1);

namespace Tests\Fixtures\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new class() implements CompilerPassInterface {
            public function process(ContainerBuilder $container): void
            {
                $definition = $container->getDefinition('monolog.logger_prototype');
                $definition->setConfigurator(AppBundle::class.'::configureLogger');
            }
        }, PassConfig::TYPE_BEFORE_OPTIMIZATION, -50);
    }

    public static function configureLogger(): void
    {
        // Do nothing
    }
}
