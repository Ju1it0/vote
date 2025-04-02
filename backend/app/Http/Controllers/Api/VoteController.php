<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Models\Voter;
use App\UseCases\VoteUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VoteController extends Controller
{
    protected $voteUseCase;

    public function __construct(VoteUseCase $voteUseCase)
    {
        $this->voteUseCase = $voteUseCase;
    }

    public function index(Request $request)
    {
        $votes = Vote::with(['voter', 'candidate'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($votes);
    }

    public function getMostVotedCandidate()
    {
        $mostVoted = DB::table('votes')
            ->select('candidateId', DB::raw('COUNT(*) as total_votes'))
            ->whereNotNull('candidateId')
            ->groupBy('candidateId')
            ->orderByDesc('total_votes')
            ->first();

        if (!$mostVoted) {
            return response()->json([
                'candidate' => null,
                'totalVotes' => 0
            ]);
        }

        $candidate = Voter::find($mostVoted->candidateId);

        return response()->json([
            'candidate' => $candidate,
            'totalVotes' => $mostVoted->total_votes
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|string|max:20',
            'candidateId' => 'required|exists:voters,id',
        ]);

        $result = $this->voteUseCase->execute($request->document, $request->candidateId);

        if (!$result['success']) {
            throw ValidationException::withMessages([
                'document' => [$result['message']],
            ]);
        }

        return response()->json([
            'message' => $result['message']
        ], 201);
    }

    public function show(Vote $vote)
    {
        $vote->load(['voter', 'candidate']);
        return response()->json($vote);
    }
}
