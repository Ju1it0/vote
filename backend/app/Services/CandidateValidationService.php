<?php

namespace App\Services;

use App\Models\Voter;
use Illuminate\Validation\ValidationException;

class CandidateValidationService
{
    public function validateCandidateExists(int $candidateId): void
    {
        $candidate = Voter::find($candidateId);

        if (!$candidate) {
            throw ValidationException::withMessages([
                'candidateId' => ['Candidato no encontrado.'],
            ]);
        }

        if (!$candidate->isCandidate) {
            throw ValidationException::withMessages([
                'candidateId' => ['El votante seleccionado no es un candidato.'],
            ]);
        }
    }

    public function getCandidates(): array
    {
        return Voter::where('isCandidate', true)->get()->toArray();
    }
} 