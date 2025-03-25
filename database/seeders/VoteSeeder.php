<?php

namespace Database\Seeders;

use App\Models\Vote;
use App\Models\Voter;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los votantes regulares y candidatos
        $voters = Voter::where('isCandidate', false)->get();
        $candidates = Voter::where('isCandidate', true)->get();

        // Crear algunos votos aleatorios
        foreach ($voters as $voter) {
            // Cada votante vota por un candidato aleatorio
            Vote::create([
                'voterId' => $voter->id,
                'candidateId' => $candidates->random()->id,
                'date' => now()->subHours(rand(1, 24)),
            ]);
        }
    }
}
