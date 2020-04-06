<?php declare(strict_types=1);

namespace Refugis\ODM\ElasticaBundle\Command;

use Refugis\ODM\Elastica\Command\UpdateSchemaCommand as BaseCommand;

class UpdateSchemaCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        parent::configure();

        $this->setName('refugis:elastica:update-schema');
    }
}
