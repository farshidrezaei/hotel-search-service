<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface RoomRepositoryContract
{

    public function get(string $query, ?int $page = 1, ?int $perPage = 15): Collection;

    public function index(array $room): void;

    public function find(string|int $roomId): Collection;

    public function destroy(string|int $roomId): void;
}