<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $topCandidates = Voter::select('voters.*', DB::raw('COUNT(votes.id) as vote_count'))
            ->join('votes', 'voters.id', '=', 'votes.candidateId')
            ->where('voters.isCandidate', true)
            ->groupBy('voters.id', 'voters.document', 'voters.name', 'voters.lastname', 'voters.dob', 'voters.isCandidate', 'voters.created_at', 'voters.updated_at')
            ->orderByDesc('vote_count')
            ->paginate(20);

        return view('admin.dashboard.index', compact('topCandidates'));
    }
}
