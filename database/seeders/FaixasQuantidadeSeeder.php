<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaixasQuantidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faixas = [
            ['min_qtd' => 30, 'max_qtd' => 49],
            ['min_qtd' => 50, 'max_qtd' => 99],
            ['min_qtd' => 100, 'max_qtd' => 199],
            ['min_qtd' => 200, 'max_qtd' => 399],
            ['min_qtd' => 400, 'max_qtd' => 599],
            ['min_qtd' => 600, 'max_qtd' => 999],
            ['min_qtd' => 1000, 'max_qtd' => 1999],
            ['min_qtd' => 2000, 'max_qtd' => 2999],
            ['min_qtd' => 3000, 'max_qtd' => 3999],
            ['min_qtd' => 4000, 'max_qtd' => 4999],
            ['min_qtd' => 5000, 'max_qtd' => 7999],
            ['min_qtd' => 8000, 'max_qtd' => 10000],
        ];

        // Adiciona 'empresa_id' => 1 a cada item
        $faixas = array_map(function ($faixa) {
            $faixa['empresa_id'] = 1;
            return $faixa;
        }, $faixas);

        DB::table('faixas_quantidade')->insert($faixas);
    }
}
