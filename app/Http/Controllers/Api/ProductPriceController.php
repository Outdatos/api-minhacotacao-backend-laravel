<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FaixaWithProductPriceResource;
use App\Models\FaixasQuantidade;

class ProductPriceController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id', // Verifica se o produto existe
            'price' => 'required|numeric', // Preço do produto
        ]);

        $productPrice = ProductPrice::create($request->all());

        return response()->json($productPrice, 201);
    }

    public function show(string $productId)
    {
        // Buscar todos os registros relacionados na tabela product_prices pelo product_id
        $productPrices = ProductPrice::where('product_id', $productId)->get();

        // Retornar usando o Resource para uma resposta formatada (se quiser)
        return FaixaWithProductPriceResource::collection($productPrices);
    }

    
    // 🎖️ [Lógica Certificada] // Evita 1 + N queries.
    public function storeOrUpdate(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'faixas' => 'required|array',
            'faixas.*.faixa_id' => 'required|exists:faixas_quantidade,id',
            'faixas.*.price' => 'nullable|numeric',
        ]);

        $empresaId = auth()->user()->empresa_id;

        $faixasValidas = FaixasQuantidade::where('empresa_id', $empresaId)
            ->pluck('id')
            ->toArray();

        foreach ($data['faixas'] as $faixa) {
            $faixaId = $faixa['faixa_id'];

            if (!in_array($faixaId, $faixasValidas)) {
                continue; 
            }

            if ($faixa['price'] === null) {
                ProductPrice::where('product_id', $data['product_id'])
                    ->where('faixa_id', $faixaId)
                    ->delete();
            } else {
                ProductPrice::updateOrCreate(
                    [
                        'product_id' => $data['product_id'],
                        'faixa_id' => $faixaId,
                    ],
                    ['price' => $faixa['price']]
                );
            }
        }

        return response()->json(['message' => 'Preços atualizados com sucesso.']);
    }
}
