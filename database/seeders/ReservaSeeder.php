<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReservaSeeder extends Seeder
{
    public function run(): void
    {
        // Coleta IDs válidos

        User::create([
            'name' => 'Ana',
            'email' => 'anaelisaarede@gmail.com',
            'password' => Hash::make('123456789'),
            'nif' => '912346789',
            'role' => 'client',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Joao',
            'email' => 'joao@exemplo.com',
            'password' => Hash::make('123456789'),
            'nif' => '922346789',
            'role' => 'client',
            'email_verified_at' => now(),
        ]);

        $userIds = DB::table('users')->pluck('id');
        $bemLocavelIds = DB::table('bens_locaveis')->pluck('id');

        if ($userIds->isEmpty() || $bemLocavelIds->isEmpty()) {
            $this->command->warn('Tabela users ou bens_locaveis está vazia. Popule-as antes de rodar este seeder.');
            return;
        }

        // Reservas com datas específicas
        $reservas = [
            [
                'data_inicio' => '2025-05-30',
                'data_fim' => '2025-06-01',
            ],
            [
                'data_inicio' => '2025-06-30',
                'data_fim' => '2025-07-03',
            ],
            [
                'data_inicio' => '2025-09-02',
                'data_fim' => '2025-09-05',
            ],
        ];

        foreach ($reservas as $reserva) {
            DB::table('reservas')->insert([
                'user_id' => $userIds->random(),
                'bem_locavel_id' => $bemLocavelIds->random(),
                'data_inicio' => $reserva['data_inicio'],
                'data_fim' => $reserva['data_fim'],
                'preco_total' => rand(300, 1000),
                'status' => 'reservado',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
