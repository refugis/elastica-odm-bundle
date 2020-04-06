<?php declare(strict_types=1);

namespace Refugis\ODM\ElasticaBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

/**
 * DoctrineDataCollector.
 */
class ElasticaDataCollector extends DataCollector
{
    /**
     * @var DebugLoggerInterface|null
     */
    private $logger;

    public function __construct($logger = null)
    {
        if ($logger instanceof DebugLoggerInterface) {
            $this->logger = $logger;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): void
    {
        if ($this->logger instanceof DebugLoggerInterface) {
            $this->logger->clear();
        }

        $this->data = [];
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, ?\Throwable $exception = null): void
    {
        if (null === $this->logger) {
            $this->data = [
                'queries' => [],
            ];

            return;
        }

        $queries = [];
        foreach ($this->logger->getLogs() as $log) {
            $request = $log['context']['request'] ?? null;
            if (null === $request) {
                continue;
            }

            $queries[] = [
                'path' => '/'.$request['path'].(! empty($request['query']) ? '?'.\http_build_query($request['query']) : ''),
                'method' => $request['method'],
                'data' => $this->cloneVar($request['data']),
                'response' => isset($log['context']['response']) ? $this->cloneVar($log['context']['response']) : null,
                'executionMs' => (int) ($log['context']['response']['took'] ?? 0),
            ];
        }

        $this->data = [
            'queries' => $queries,
        ];
    }

    public function getQueryCount(): int
    {
        return \count($this->data['queries']);
    }

    public function getQueries(): array
    {
        return $this->data['queries'];
    }

    public function getTime(): int
    {
        $time = 0;
        foreach ($this->data['queries'] as $query) {
            $time += $query['executionMs'];
        }

        return $time;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'elastica_odm';
    }
}
