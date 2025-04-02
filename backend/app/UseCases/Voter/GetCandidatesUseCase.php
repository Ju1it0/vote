<?php

namespace App\UseCases\Voter;

use App\Models\Voter;
use Illuminate\Database\Eloquent\Collection;

class GetCandidatesUseCase
{
    public function execute(): Collection
    {
        return Voter::where('isCandidate', true)->get();
    }
}
