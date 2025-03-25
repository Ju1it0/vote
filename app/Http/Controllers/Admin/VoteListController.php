<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Models\Voter;
use Illuminate\Support\Facades\DB;

class VoteListController extends Controller
{
    public function index()
    {
        // Obtener el candidato que va ganando
        $topCandidate = Voter::select('voters.*', DB::raw('COUNT(votes.id) as vote_count'))
            ->join('votes', 'voters.id', '=', 'votes.candidateId')
            ->where('voters.isCandidate', true)
            ->groupBy('voters.id', 'voters.document', 'voters.name', 'voters.lastname', 'voters.dob', 'voters.isCandidate', 'voters.created_at', 'voters.updated_at')
            ->orderByDesc('vote_count')
            ->first();

        // Obtener el listado de votos con información básica
        $votes = Vote::with(['voter:id,name,lastname', 'candidate:id,name,lastname'])
            ->orderByDesc('date')
            ->paginate(20);

        return view('admin.votes.index', compact('topCandidate', 'votes'));
    }

    public function show(Vote $vote)
    {
        $vote->load(['voter', 'candidate']);
        return response()->json($vote);
    }
}
