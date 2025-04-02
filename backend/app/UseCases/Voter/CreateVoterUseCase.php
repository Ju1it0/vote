<?php

namespace App\UseCases\Voter;

use App\Models\Voter;
use App\Services\DocumentValidationService;

class CreateVoterUseCase
{
    public function __construct(
        private DocumentValidationService $documentValidationService
    ) {}

    public function execute(array $data): Voter
    {
        $this->documentValidationService->validateUniqueDocument($data['document']);

        return Voter::create($data);
    }
} 