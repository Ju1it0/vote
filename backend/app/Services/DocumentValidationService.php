<?php

namespace App\Services;

use App\Models\Voter;
use App\Models\Vote;
use Illuminate\Validation\ValidationException;

class DocumentValidationService
{
    public function validateUniqueDocument(string $document): void
    {
        if (Voter::where('document', $document)->exists()) {
            throw ValidationException::withMessages([
                'document' => ['El documento ya está registrado.'],
            ]);
        }
    }

    public function validateDocumentExists(string $document): void
    {
        if (!Voter::where('document', $document)->exists()) {
            throw ValidationException::withMessages([
                'document' => ['El documento no está registrado.'],
            ]);
        }
    }

    public function validateDocumentHasNotVoted(string $document): void
    {
        if (Vote::whereHas('voter', function ($query) use ($document) {
            $query->where('document', $document);
        })->exists()) {
            throw ValidationException::withMessages([
                'document' => ['Este documento ya ha votado.'],
            ]);
        }
    }
} 