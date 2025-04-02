<?php

namespace App\UseCases\Vote;

use App\Models\Vote;
use App\Services\DocumentValidationService;
use App\Services\CandidateValidationService;
use App\Services\VoterSearchService;

class CreateVoteUseCase
{
    public function __construct(
        private DocumentValidationService $documentValidationService,
        private CandidateValidationService $candidateValidationService,
        private VoterSearchService $voterSearchService
    ) {}

    public function execute(array $data): array
    {
        $this->documentValidationService->validateDocumentExists($data['document']);
        $this->documentValidationService->validateDocumentHasNotVoted($data['document']);
        $this->candidateValidationService->validateCandidateExists($data['candidateId']);

        $voter = $this->voterSearchService->findByDocument($data['document']);
        $candidate = $this->voterSearchService->findById($data['candidateId']);

        $vote = Vote::create([
            'voterId' => $voter->id,
            'candidateId' => $candidate->id,
            'date' => now(),
        ]);

        return [
            'message' => 'Voto registrado exitosamente',
            'vote' => $vote,
        ];
    }
}
