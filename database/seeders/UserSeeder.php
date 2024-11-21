<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Guilherme Florencio',
            'email' => 'guilherme.florencio@cashpago.com.br',
            'password' => Hash::make('aprovado'),
        ]);

        User::create([
            'name' => 'Lucas Resende',
            'email' => 'lucas.resende@cashpago.com.br.com',
            'password' => Hash::make('aprovado'),
        ]);
    }
}
