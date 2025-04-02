<?php

namespace App\UseCases\Voter;

use App\Models\Voter;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteVoterUseCase
{
    public function execute(int $id): void
    {
        $voter = Voter::find($id);
        
        if (!$voter) {
            throw new ModelNotFoundException('Votante no encontrado');
        }

        $voter->delete();
    }
} 