<?php

namespace App\UseCases\Voter;

use App\Models\Voter;
use Illuminate\Database\Eloquent\Collection;

class GetTopCandidatesUseCase
{
    public function execute(): Collection
    {
        return Voter::where('isCandidate', true)
            ->withCount('receivedVotes')
            ->orderByDesc('received_votes_count')
            ->get();
    }
}
