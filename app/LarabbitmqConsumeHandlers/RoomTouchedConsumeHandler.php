<?php

namespace App\LarabbitmqConsumeHandlers;

use App\Contracts\RoomRepositoryContract;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;
use FarshidRezaei\Larabbitmq\Lib\LarabbitmqQueueConsumeHandler;

class RoomTouchedConsumeHandler implements LarabbitmqQueueConsumeHandler
{

    public function __construct(private readonly RoomRepositoryContract $roomRepository)
    {
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     * @throws Exception
     */
    public function handle(mixed $data): void
    {
        $payload = json_decode($data, true);
        match ($payload['changeType']) {
            'updated', 'created' => $this->roomRepository->index($payload['room']),
            'deleted' => $this->roomRepository->destroy($payload['room']['id'])
        };
    }



}
