<?php

namespace App\Repositories;

use App\Contracts\RoomRepositoryContract;
use App\Library\Elasticsearch\Elasticsearch;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;
use Illuminate\Support\Collection;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class RoomRepository extends AbstractRepository implements RoomRepositoryContract
{

    private readonly Elasticsearch $elastic;

    public function __construct()
    {
        $this->elastic = new Elasticsearch('room');
    }


    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function get(string $query, ?int $page = 1, ?int $perPage = 15): Collection
    {
        return $this->elastic->get($query, $page, $perPage);
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ClientResponseException
     * @throws ContainerExceptionInterface
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function find(string|int $roomId): Collection
    {
        return $this->elastic->find($roomId);
    }

    /**
     * @throws Exception
     */
    public function index(array $room): void
    {
        $this->elastic->index($room['id'], $room);
    }


    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function destroy(string|int $roomId): void
    {
        $this->elastic->delete($roomId);
    }


}