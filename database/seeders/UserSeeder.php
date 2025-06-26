<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criando usuários com dados específicos
        User::create([
            'name' => 'Gerenciador',
            'last_name' => 'Master',
            'email' => 'gerenciadormaster@email.com',
            'password' => Hash::make('123456'), // A senha precisa ser criptografada
            'address' => '',
            'city' => '',
            'country' => '',
            'zip_code' => '',
            'phone_number' => '(00) 00000-0000',
            'profile_image' => '',
            'profile_completed' => false,
            'role' => 'master',
        ]);
        User::create([
            'name' => 'Gerenciador2',
            'last_name' => 'Master',
            'email' => 'gerenciadormaster2@email.com',
            'password' => Hash::make('123456'), // A senha precisa ser criptografada
            'address' => '',
            'city' => '',
            'country' => '',
            'zip_code' => '',
            'phone_number' => '(00) 00000-0000',
            'profile_image' => '',
            'profile_completed' => false,
            'role' => 'admin',
            'empresa_id' => 1, // Certifique-se de que a empresa com ID 1 existe
        ]);
    }
}
