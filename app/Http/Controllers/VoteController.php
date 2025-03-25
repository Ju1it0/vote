<?php

namespace App\Http\Controllers;

use App\Models\Voter;
use App\UseCases\VoteUseCase;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    protected $voteUseCase;

    public function __construct(VoteUseCase $voteUseCase)
    {
        $this->voteUseCase = $voteUseCase;
    }

    public function index()
    {
        $candidates = Voter::where('isCandidate', true)->get();
        return view('vote.index', compact('candidates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|string',
            'candidate_id' => 'required|exists:voters,id',
        ]);

        $result = $this->voteUseCase->execute(
            $request->document,
            $request->candidate_id
        );

        return back()->with('message', $result['message'])
            ->with('success', $result['success']);
    }
} 