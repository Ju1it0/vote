<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationService
{
    public function paginate(Builder $query, int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
} 