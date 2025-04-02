<?php

namespace Database\Seeders;

use App\Models\Voter;
use Illuminate\Database\Seeder;

class VoterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 8 votantes regulares
        for ($i = 1; $i <= 47; $i++) {
            Voter::create([
                'document' => 'VOT' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => 'Votante',
                'lastname' => 'Regular ' . $i,
                'dob' => now()->subYears(rand(18, 70)),
                'isCandidate' => false,
            ]);
        }

        // Crear 2 candidatos
        for ($i = 1; $i <= 3; $i++) {
            Voter::create([
                'document' => 'CAN' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => 'Candidato',
                'lastname' => $i,
                'dob' => now()->subYears(rand(30, 60)),
                'isCandidate' => true,
            ]);
        }
    }
}
