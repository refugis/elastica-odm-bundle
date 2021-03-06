<?php declare(strict_types=1);

namespace Tests\Fixtures\DataCollector;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Tests\Fixtures\DependencyInjection\AppKernel;

class ElasticaDataCollectorTest extends WebTestCase
{
    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass(): void
    {
        $fs = new Filesystem();
        $fs->remove(__DIR__.'/../../../var/cache');
        $fs->remove(__DIR__.'/../../../var/logs');
    }

    /**
     * {@inheritdoc}
     */
    protected static function getKernelClass(): string
    {
        return AppKernel::class;
    }

    public function testShouldCollectCorrectDataAfterResponse(): void
    {
        $client = self::createClient();
        $client->request('GET', '/');

        $collector = $client->getProfile()->getCollector('elastica_odm');
        self::assertNotNull($collector);
    }
}
