<?php

namespace App\UseCases;

use App\Models\Vote;
use App\Models\Voter;
use Exception;

class VoteUseCase
{
    public function execute(string $document, int $candidateId): array
    {
        try {
            // Verificar si el votante existe
            $voter = Voter::where('document', $document)->first();
            if (!$voter) {
                return [
                    'success' => false,
                    'message' => 'El documento ingresado no existe en el sistema.'
                ];
            }

            // Verificar si el votante ya ha votado
            $existingVote = Vote::where('voterId', $voter->id)->first();
            if ($existingVote) {
                return [
                    'success' => false,
                    'message' => 'Este documento ya ha sido utilizado para votar.'
                ];
            }

            // Verificar si el candidato existe y es un candidato válido
            $candidate = Voter::where('id', $candidateId)
                ->where('isCandidate', true)
                ->first();

            if (!$candidate) {
                return [
                    'success' => false,
                    'message' => 'El candidato seleccionado no es válido.'
                ];
            }

            // Crear el voto
            Vote::create([
                'voterId' => $voter->id,
                'candidateId' => $candidateId,
                'date' => now(),
            ]);

            return [
                'success' => true,
                'message' => 'Voto registrado correctamente.'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al procesar el voto: ' . $e->getMessage()
            ];
        }
    }
}
