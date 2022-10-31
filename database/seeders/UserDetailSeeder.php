<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'name' => 'angel',
            'email' => 'angel@gcs.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Angel123'),
            'is_admin' => false,
            'remember_token' => Str::random(10),
        ]);

        $user->user_detail()->create([
            'first_name' => "Angel",
            'first_surname' => "Saravia",
            'second_email' => 'sebastian@gcs.com',
            'cell_phone' => "1478963",
            'country_id' => 10,
            'role' => "Administrador",
        ]);
    }
}
