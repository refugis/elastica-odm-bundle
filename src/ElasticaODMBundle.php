<?php declare(strict_types=1);

namespace Refugis\ODM\ElasticaBundle;

use Refugis\ODM\Elastica\Type\TypeInterface;
use Refugis\ODM\ElasticaBundle\DependencyInjection\Compiler\AddElasticaTypesCompilerPass;
use Refugis\ODM\ElasticaBundle\DependencyInjection\Compiler\DebugPass;
use Refugis\ODM\ElasticaBundle\DependencyInjection\Compiler\FixturesCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class ElasticaODMBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        $container
            ->registerForAutoconfiguration(TypeInterface::class)
            ->addTag('elastica.type')
        ;

        $container
            ->addCompilerPass(new AddElasticaTypesCompilerPass())
            ->addCompilerPass(new FixturesCompilerPass())
            ->addCompilerPass(new DebugPass())
        ;
    }
}
