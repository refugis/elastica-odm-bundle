<?php declare(strict_types=1);

namespace Tests\Fixtures\Document;

use Refugis\ODM\Elastica\Annotation\Document;
use Refugis\ODM\Elastica\Annotation\DocumentId;
use Refugis\ODM\Elastica\Annotation\Field;

/**
 * @Document("foo_index/foo_type")
 */
class Foo
{
    /**
     * @var string
     *
     * @DocumentId()
     */
    public $id;

    /**
     * @var string
     *
     * @Field()
     */
    public $stringField;
}
