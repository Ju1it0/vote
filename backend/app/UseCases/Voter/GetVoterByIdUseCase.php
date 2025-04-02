<?php

namespace App\UseCases\Voter;

use App\Models\Voter;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetVoterByIdUseCase
{
    public function execute(int $id): Voter
    {
        $voter = Voter::find($id);
        
        if (!$voter) {
            throw new ModelNotFoundException('Votante no encontrado');
        }

        return $voter;
    }
} 