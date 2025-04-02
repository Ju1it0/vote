<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCases\Voter\GetAllVotersUseCase;
use App\UseCases\Voter\GetVoterByIdUseCase;
use App\UseCases\Voter\CreateVoterUseCase;
use App\UseCases\Voter\UpdateVoterUseCase;
use App\UseCases\Voter\DeleteVoterUseCase;
use App\UseCases\Voter\GetCandidatesUseCase;
use App\UseCases\Voter\GetTopCandidatesUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VoterController extends Controller
{
    public function __construct(
        private GetAllVotersUseCase $getAllVotersUseCase,
        private GetVoterByIdUseCase $getVoterByIdUseCase,
        private CreateVoterUseCase $createVoterUseCase,
        private UpdateVoterUseCase $updateVoterUseCase,
        private DeleteVoterUseCase $deleteVoterUseCase,
        private GetCandidatesUseCase $getCandidatesUseCase,
        private GetTopCandidatesUseCase $getTopCandidatesUseCase
    ) {}

    public function index(Request $request): JsonResponse
    {
        $page = $request->query('page', 1);
        $voters = $this->getAllVotersUseCase->execute($page);

        return response()->json($voters);
    }

    public function show(int $id): JsonResponse
    {
        $voter = $this->getVoterByIdUseCase->execute($id);
        return response()->json($voter);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'document' => 'required|string|max:20',
            'dob' => 'required|date',
            'gender' => 'required|in:M,F,O',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'isCandidate' => 'boolean',
        ]);

        $voter = $this->createVoterUseCase->execute($data);
        return response()->json($voter, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'lastname' => 'sometimes|string|max:255',
            'document' => 'sometimes|string|max:20',
            'dob' => 'sometimes|date',
            'gender' => 'sometimes|in:M,F,O',
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string|max:255',
            'isCandidate' => 'sometimes|boolean',
        ]);

        $voter = $this->updateVoterUseCase->execute($id, $data);
        return response()->json($voter);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->deleteVoterUseCase->execute($id);
        return response()->json(null, 204);
    }

    public function candidates(): JsonResponse
    {
        $candidates = $this->getCandidatesUseCase->execute();
        return response()->json($candidates);
    }

    public function topCandidates(): JsonResponse
    {
        $candidates = $this->getTopCandidatesUseCase->execute();
        return response()->json(['data' => $candidates]);
    }
}
