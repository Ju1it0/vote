<?php

namespace App\Services;

use App\Models\Voter;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VoterSearchService
{
    public function findById(int $id): Voter
    {
        $voter = Voter::find($id);
        
        if (!$voter) {
            throw new ModelNotFoundException('Votante no encontrado');
        }

        return $voter;
    }

    public function findByDocument(string $document): Voter
    {
        $voter = Voter::where('document', $document)->first();
        
        if (!$voter) {
            throw new ModelNotFoundException('Votante no encontrado');
        }

        return $voter;
    }
} 