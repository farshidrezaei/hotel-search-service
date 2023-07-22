<?php

namespace App\Library\Elasticsearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Elasticsearch
{
    private readonly Client $elasticClient;

    public function __construct(private readonly string $index)
    {
        $this->elasticClient = app('elasticSearch');
    }


    /**
     * @param  string  $query
     * @param  int|null  $page
     * @param  int|null  $size
     * @return Collection
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function get(string $query, ?int $page = 1, ?int $size = 15): Collection
    {
        $search = [
            'index' => $this->index,
            'type' => '_doc',
            'body' => [
                "from" => $page * $size,
                "size" => $size,
                'query' => [
                    'multi_match' => [
                        'fields' => ['price_per_night', 'beds_count', 'special_properties.value'],
                        'query' => $query,
                    ],
                ],
            ],
        ];

        $response = $this->elasticClient->search($search);
        return collect($response['hits']['hits']);
    }


    /**
     * @param  int  $id
     * @return Collection
     * @throws ClientResponseException
     * @throws ContainerExceptionInterface
     * @throws MissingParameterException
     * @throws NotFoundExceptionInterface
     * @throws ServerResponseException
     */
    public function find(int $id): Collection
    {
        $params = [
            'index' => $this->index,
            'id' => $id,
        ];

        try {
            $this->elasticClient->get($params);
        } catch (Exception $exception) {
            Log::critical('room deletion failed.', [
                'message' => $exception->getMessage(),
                'exception' => get_class($exception),
            ]);
            throw $exception;
        }
        return collect($this->elasticClient->get($params)['_source']);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function index(int|string $id, array $body): void
    {
        $params = [
            'index' => $this->index,
            'id' => $id,
            'body' => $body,
        ];

        $this->elasticClient->index($params);
    }


    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function delete(string|int $id): void
    {
        $params = [
            'index' => $this->index,
            'id' => $id,
        ];

        try {
            $this->elasticClient->delete($params);
        } catch (Exception $exception) {
            Log::critical('room deletion failed.', [
                'message' => $exception->getMessage(),
                'exception' => get_class($exception),
            ]);
            throw $exception;
        }
    }
}