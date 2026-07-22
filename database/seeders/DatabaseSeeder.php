<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $lppm = \App\Models\Division::create([
            'name' => 'LPPM'
        ]);

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin'),
            'role' => 'admin',
            'division_id' => null,
        ]);

        User::create([
            'name' => 'Divisi LPPM',
            'email' => 'lppm@lppm.com',
            'password' => \Illuminate\Support\Facades\Hash::make('lppm'),
            'role' => 'divisi',
            'division_id' => $lppm->id,
        ]);
    }
}
