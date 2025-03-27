<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Models\Voter;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVoters = Voter::count();
        $totalVotes = Vote::count();
        $totalCandidates = Voter::where('isCandidate', true)->count();

        $votesByCandidate = Vote::selectRaw('candidateId, count(*) as total')
            ->groupBy('candidateId')
            ->with('candidate:id,name,lastname')
            ->get()
            ->map(function ($vote) {
                return [
                    'candidate' => $vote->candidate ? $vote->candidate->name . ' ' . $vote->candidate->lastname : 'Desconocido',
                    'total' => $vote->total
                ];
            });

        return response()->json([
            'total_voters' => $totalVoters,
            'total_votes' => $totalVotes,
            'total_candidates' => $totalCandidates,
            'votes_by_candidate' => $votesByCandidate,
        ]);
    }
}
