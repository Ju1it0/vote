<?php

namespace App\UseCases\Voter;

use App\Models\Voter;
use App\Services\DocumentValidationService;
use App\Services\VoterSearchService;

class UpdateVoterUseCase
{
    public function __construct(
        private DocumentValidationService $documentValidationService,
        private VoterSearchService $voterSearchService
    ) {}

    public function execute(int $id, array $data): Voter
    {
        $voter = $this->voterSearchService->findById($id);
        
        if (isset($data['document']) && $data['document'] !== $voter->document) {
            $this->documentValidationService->validateUniqueDocument($data['document']);
        }

        $voter->update($data);
        return $voter;
    }
} 