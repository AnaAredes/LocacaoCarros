<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // User::factory(5)->create();

        User::factory()->create([
            'name' => 'Ana Aredes',
            'email' => 'ana@example.com',
            'nif'=> '213456789',
        ]);

        User::factory()->create([
            'name' => 'Hugo Gomes',
            'email' => 'hugo@example.com',
            'nif'=> '231456789',
        ]);

        User::factory()->create([
            'name' => 'Maria',
            'email' => 'maria@example.com',
            'nif'=> '241456789',
            'role'=> 'admin',
        ]);

        $this->call([
            ReservaSeeder::class,
        ]);
    }
}
