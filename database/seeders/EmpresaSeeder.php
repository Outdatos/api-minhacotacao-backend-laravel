<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criando empresas fictícias
        Empresa::create([
            'name' => 'GERENCIADOR MASTER',
            'cnpj' => '00.000.000/0000-00',
            'email' => 'gerenciadormaster@email.com',
            'phone_number' => '(00) 00000-0000'
        ]);

        Empresa::create([
            'name' => 'PANO AZUL BONES PROMOCIONAIS LTDA',
            'cnpj' => '55.222.008/0001-70',
            'email' => 'panoazul@email.com',
            'phone_number' => '(99) 00000-0000'
        ]);
    }
}
