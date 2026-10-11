<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@erp.com'],
            [
                'name' => 'Administrador XIS',
                'password' => Hash::make('admin123456'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'tecnico@erp.com'],
            [
                'name' => 'Técnico de Reparaciones',
                'password' => Hash::make('tecnico123456'),
                'role' => 'technician',
                'is_active' => true,
            ]
        );
    }
}
