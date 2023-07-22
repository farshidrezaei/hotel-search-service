<?php

namespace App\Http\Controllers\V1;

use App\Contracts\RoomRepositoryContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Http\Resources\RoomResource;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    public function __construct(private readonly RoomRepositoryContract $roomRepository)
    {
    }

    public function index(RoomRequest $request): JsonResponse
    {
        $room = $this->roomRepository->get(
            $request->validated('query'),
            $request->validated('page'),
            $request->validated('per_page')
        );

        return new JsonResponse(['message' => 'rooms indexed.', 'room' => RoomResource::collection($room)]);
    }

    public function show(int|string $id): JsonResponse
    {
        $room = $this->roomRepository->find($id);

        return new JsonResponse(['message' => 'room fetched.', 'room' => RoomResource::make($room)]);
    }
}
