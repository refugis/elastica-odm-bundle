<?php declare(strict_types=1);

namespace Refugis\ODM\ElasticaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class FixturesCompilerPass implements CompilerPassInterface
{
    public const FIXTURE_TAG = 'elastica.fixture';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (! $container->hasDefinition('elastica.fixtures.loader')) {
            return;
        }

        $definition = $container->findDefinition('elastica.fixtures.loader');
        $taggedServices = $container->findTaggedServiceIds(self::FIXTURE_TAG);

        $fixtures = [];
        foreach ($taggedServices as $serviceId => $tags) {
            $fixtures[] = new Reference($serviceId);
        }

        $definition->addMethodCall('addFixtures', [$fixtures]);
    }
}
