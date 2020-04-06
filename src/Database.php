<?php declare(strict_types=1);

namespace Refugis\ODM\ElasticaBundle;

use Elastica\Client;
use Elastica\SearchableInterface;
use Refugis\ODM\Elastica\Collection\Database as BaseDatabase;
use Refugis\ODM\Elastica\Metadata\DocumentMetadata;

class Database extends BaseDatabase
{
    /**
     * @var string
     */
    private $suffix;

    public function __construct(Client $elasticSearch, ?string $suffix)
    {
        $this->suffix = $suffix;

        parent::__construct($elasticSearch);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSearchable(DocumentMetadata $class): SearchableInterface
    {
        [$indexName, $typeName] = \explode('/', $class->collectionName, 2) + [null, null];

        $searchable = $this->elasticSearch->getIndex($indexName.$this->suffix);
        if (null !== $typeName) {
            $searchable = $searchable->getType($typeName);
        }

        return $searchable;
    }
}
