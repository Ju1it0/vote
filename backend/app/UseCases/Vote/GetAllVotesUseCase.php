<?php

namespace App\UseCases\Vote;

use App\Models\Vote;
use App\Services\PaginationService;
use Illuminate\Pagination\LengthAwarePaginator;

class GetAllVotesUseCase
{
    public function __construct(
        private PaginationService $paginationService
    ) {}

    public function execute(int $page = 1): LengthAwarePaginator
    {
        return $this->paginationService->paginate(
            Vote::with(['voter', 'candidate'])->orderByDesc('created_at'),
            $page
        );
    }
} 