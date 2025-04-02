<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCases\Vote\GetAllVotesUseCase;
use App\UseCases\Vote\GetMostVotedCandidateUseCase;
use App\UseCases\Vote\CreateVoteUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VoteController extends Controller
{
    public function __construct(
        private GetAllVotesUseCase $getAllVotesUseCase,
        private GetMostVotedCandidateUseCase $getMostVotedCandidateUseCase,
        private CreateVoteUseCase $createVoteUseCase
    ) {}

    public function index(Request $request): JsonResponse
    {
        $page = $request->query('page', 1);
        $votes = $this->getAllVotesUseCase->execute($page);

        return response()->json($votes);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'document' => 'required|string',
            'candidateId' => 'required|integer',
        ]);

        $result = $this->createVoteUseCase->execute($data);
        return response()->json($result, 201);
    }

    public function getMostVotedCandidate(): JsonResponse
    {
        $result = $this->getMostVotedCandidateUseCase->execute();
        return response()->json($result);
    }
}
