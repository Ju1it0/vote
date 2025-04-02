<?php

namespace App\UseCases\Vote;

use App\Models\Voter;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;

class GetMostVotedCandidateUseCase
{
    public function execute(): array
    {
        $mostVoted = Vote::select('candidateId', DB::raw('count(*) as totalVotes'))
            ->whereNotNull('candidateId')
            ->groupBy('candidateId')
            ->orderByDesc('totalVotes')
            ->first();

        if (!$mostVoted) {
            return [
                'candidate' => null,
                'totalVotes' => 0,
            ];
        }

        $candidate = Voter::find($mostVoted->candidateId);

        return [
            'candidate' => $candidate,
            'totalVotes' => $mostVoted->totalVotes,
        ];
    }
} 