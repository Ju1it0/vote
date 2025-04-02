<?php

namespace Database\Seeders;

use App\Models\Voter;
use Illuminate\Database\Seeder;

class VoterSeeder extends Seeder
{
    private array $genders = ['M', 'F', 'O'];
    private array $addresses = [
        'Calle Principal 123',
        'Avenida Central 456',
        'Plaza Mayor 789',
        'Callejón del Sol 321',
        'Boulevard Norte 654',
        'Calle Sur 987',
        'Avenida Este 147',
        'Calle Oeste 258',
        'Plaza Central 369',
        'Callejón de la Luna 741',
    ];

    private array $phonePrefixes = ['+54', '+56', '+57', '+58', '+59', '+60'];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 47; $i++) {
            Voter::create([
                'document' => 'VOT' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => 'Votante',
                'lastname' => 'Regular ' . $i,
                'dob' => now()->subYears(rand(18, 70)),
                'isCandidate' => false,
                'gender' => $this->genders[array_rand($this->genders)],
                'address' => $this->addresses[array_rand($this->addresses)],
                'phone' => $this->phonePrefixes[array_rand($this->phonePrefixes)] . rand(100000000, 999999999),
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            Voter::create([
                'document' => 'CAN' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => 'Candidato',
                'lastname' => $i,
                'dob' => now()->subYears(rand(30, 60)),
                'isCandidate' => true,
                'gender' => $this->genders[array_rand($this->genders)],
                'address' => $this->addresses[array_rand($this->addresses)],
                'phone' => $this->phonePrefixes[array_rand($this->phonePrefixes)] . rand(100000000, 999999999),
            ]);
        }
    }
}
