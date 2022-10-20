<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\User::create([
            'name' => 'Super Administrador',
            'email' => 'super_admin@gcs.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Super123'),
            'remember_token' => Str::random(10),
        ]);
    }
}
