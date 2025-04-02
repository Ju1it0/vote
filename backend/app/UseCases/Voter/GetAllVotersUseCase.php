<?php

namespace App\UseCases\Voter;

use App\Models\Voter;
use App\Services\PaginationService;
use Illuminate\Pagination\LengthAwarePaginator;

class GetAllVotersUseCase
{
    public function __construct(
        private PaginationService $paginationService
    ) {}

    public function execute(int $page = 1): LengthAwarePaginator
    {
        return $this->paginationService->paginate(Voter::query(), $page);
    }
} 