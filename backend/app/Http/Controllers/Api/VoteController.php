<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\UseCases\VoteUseCase;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VoteController extends Controller
{
    protected $voteUseCase;

    public function __construct(VoteUseCase $voteUseCase)
    {
        $this->voteUseCase = $voteUseCase;
    }

    public function index()
    {
        $votes = Vote::with(['voter:id,name,lastname,document', 'candidate:id,name,lastname'])->get();

        return response()->json($votes);
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
        return response()->json($vote->load(['voter:id,name,lastname,document', 'candidate:id,name,lastname']));
    }
}
