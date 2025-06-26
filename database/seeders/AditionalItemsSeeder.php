<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AditionalItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $items = [
            [ 'id' => 1,   'descricao' => 'Bordado lateral ou traseiro (telefone, endereço, 1 bandeira ou frases)', 'price' => 0.80 ],
            [ 'id' => 2,   'descricao' => 'Bordado lateral ou traseiro (Logotipo)', 'price' => 1.16 ],
            [ 'id' => 3,   'descricao' => 'Bordado frontal sem EVA (até 7000 pontos)', 'price' => 1.52 ],
            [ 'id' => 4,   'descricao' => 'Bordado frontal com EVA (até 7000 pontos)', 'price' => 2.13 ],
            [ 'id' => 5,   'descricao' => 'Aplique de patch bordado com silk relevo / DTF (Frontal)', 'price' => 3.28 ],
            [ 'id' => 6,   'descricao' => 'Aplique de patch queimado a laser (Frontal e lateral)', 'price' => 2.54 ],
            [ 'id' => 7,   'descricao' => 'Aplique de patch bordado com silk relevo / DTF (Lateral)', 'price' => 2.54 ],
            [ 'id' => 8,   'descricao' => 'Aplique de patch bordado (Lateral)', 'price' => 2.54 ],
            [ 'id' => 9,   'descricao' => 'Costura na aba (cada)', 'price' => 0.09 ],
            [ 'id' => 10,  'descricao' => 'Tihs bordado (Unidade)', 'price' => 0.12 ],
            [ 'id' => 11,  'descricao' => 'Thos oval', 'price' => 0.36 ],
            [ 'id' => 12,  'descricao' => 'Fivela personalizada (Cliché)', 'price' => 780.00 ],
            [ 'id' => 13,  'descricao' => 'Fivela personalizada (mínimo 1000 un)', 'price' => 0.30 ],
            [ 'id' => 14,  'descricao' => 'Espelho de micro', 'price' => 0.70 ],
            [ 'id' => 15,  'descricao' => 'Espelho de micro personalizado', 'price' => 1.50 ],
            [ 'id' => 16,  'descricao' => 'Aba com Puído (Rasgado)', 'price' => 1.45 ],
            [ 'id' => 17,  'descricao' => 'Aba sanduíche', 'price' => 0.29 ],
            [ 'id' => 18,  'descricao' => 'Laterais e traseiro furado no laser', 'price' => 3.63 ],
            [ 'id' => 19,  'descricao' => 'Silk relevo frontal abaixo de 100 un', 'price' => 2.00 ],
            [ 'id' => 20,  'descricao' => 'Silk relevo frontal acima de 100 un', 'price' => 1.70 ],
            [ 'id' => 21,  'descricao' => 'Silk relevo frontal acima de 5 cores e abaixo de 100 un', 'price' => 3.00 ],
            [ 'id' => 22,  'descricao' => 'Silk relevo frontal acima de 5 cores e acima de 100 un', 'price' => 2.50 ],
            [ 'id' => 23,  'descricao' => 'Silk relevo lateral / traseiro no tecido abaixo de 100 un', 'price' => 1.40 ],
            [ 'id' => 24,  'descricao' => 'Silk relevo lateral / traseiro no tecido acima de 100 un', 'price' => 1.20 ],
            [ 'id' => 25,  'descricao' => 'Silk relevo na tela abaixo de 100 un', 'price' => 1.70 ],
            [ 'id' => 26,  'descricao' => 'Silk relevo na tela acima de 100 un', 'price' => 1.50 ],
            [ 'id' => 27,  'descricao' => 'Silk relevo frontal + 1 lateral ou traseiro em tecido abaixo de 100 un', 'price' => 3.00 ],
            [ 'id' => 28,  'descricao' => 'Silk relevo frontal + 1 lateral ou traseiro em tecido acima de 100 un', 'price' => 2.60 ],
            [ 'id' => 29,  'descricao' => 'Silk relevo na DUAS LATERAIS de tela abaixo de 100 un', 'price' => 2.70 ],
            [ 'id' => 30,  'descricao' => 'Silk relevo na DUAS LATERAIS de tela acima de 100 un', 'price' => 2.30 ],
            [ 'id' => 31,  'descricao' => 'Silk relevo frontal + 2 laterais ou traseiras abaixo de 100 un', 'price' => 3.20 ],
            [ 'id' => 32,  'descricao' => 'Silk relevo frontal + 2 laterais ou traseiras acima de 100 un', 'price' => 2.80 ],
            [ 'id' => 33,  'descricao' => 'Silk relevo frontal + 1 lateral ou traseiro na tela', 'price' => 3.20 ],
            [ 'id' => 34,  'descricao' => 'Silk relevo frontal + 2 laterais ou traseiro na tela', 'price' => 3.80 ],
            [ 'id' => 35,  'descricao' => 'Silk comum (boné todo)', 'price' => 0.85 ],
            [ 'id' => 36,  'descricao' => 'Fecho de areata com passante', 'price' => 0.73 ],
            [ 'id' => 37,  'descricao' => 'Impressão DTF lateral / traseiro', 'price' => 0.90 ],
            [ 'id' => 38,  'descricao' => 'Impressão DTF frontal', 'price' => 1.30 ],
            [ 'id' => 39,  'descricao' => 'Vids personalizado acima de 200 un', 'price' => 0.85 ],
            [ 'id' => 40,  'descricao' => 'Fecho de Areata + fivela lisa', 'price' => 0.80 ],
            [ 'id' => 41,  'descricao' => 'Fecho de Velcro', 'price' => 0.40 ],
            [ 'id' => 42,  'descricao' => 'Areata + esconderijo na câmera', 'price' => 1.00 ],
            [ 'id' => 43,  'descricao' => 'Câmera PS na cor do boné (abaixo de 300 un)', 'price' => 1.50 ],
            [ 'id' => 44,  'descricao' => 'Câmera PS na cor do boné (acima de 300 un)', 'price' => 0.80 ],
            [ 'id' => 45,  'descricao' => 'Tela Brannil', 'price' => 0.90 ],
            [ 'id' => 46,  'descricao' => 'Saia para chapéu / boné (brim pesado)', 'price' => 5.22 ],
            [ 'id' => 47,  'descricao' => 'Saia para chapéu / boné (brim leve)', 'price' => 4.59 ],
            [ 'id' => 48,  'descricao' => 'Saia para chapéu / boné (microfibra)', 'price' => 1.90 ],
            [ 'id' => 49,  'descricao' => 'Forro de brim para chapéu', 'price' => 2.20 ],
            [ 'id' => 50,  'descricao' => 'Forro de micro para chapéu', 'price' => 0.53 ],
        ];

        // Adiciona 'empresa_id' => 1 a cada item
        $items = array_map(function ($item) {
            $item['empresa_id'] = 1;
            return $item;
        }, $items);

        DB::table('aditional_items')->insert($items);
    }
}
