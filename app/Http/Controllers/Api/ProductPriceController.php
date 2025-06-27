<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FaixaWithProductPriceResource;

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
    
    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
        // $productPrice = ProductPrice::findOrFail($id);

        // $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'price' => 'required|numeric',
        // ]);

        // $productPrice->update($request->all());

        // return response()->json($productPrice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        // $productPrice = ProductPrice::findOrFail($id);
        // $productPrice->delete();

        // return response()->json(['message' => 'Product price deleted successfully']);
    }

    public function saveProductPrices(Request $request)
    {
        foreach ($request->prices as $priceData) {
            ProductPrice::updateOrCreate(
                [
                    'product_id' => $priceData['product_id'],
                    'faixa_id' => $priceData['faixa_id']
                ],
                [
                    'price' => $priceData['price']
                ]
            );
        }

        return response()->json(['message' => 'Tabela atualizada com sucesso!']);
    }

    public function storeOrUpdate(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'faixas' => 'required|array',
            'faixas.*.faixa_id' => 'required|exists:faixas_quantidade,id',
            'faixas.*.price' => 'nullable|numeric',
        ]);

        $empresaId = auth()->user()->empresa_id;

        foreach ($data['faixas'] as $faixa) {
            if ($faixa['price'] === null) {
                // Se o preço for null, exclui o registro, se pertencer à empresa do usuário
                ProductPrice::where('product_id', $data['product_id'])
                    ->where('faixa_id', $faixa['faixa_id'])
                    ->whereHas('faixa', function ($query) use ($empresaId) {
                        $query->where('empresa_id', $empresaId);
                    })
                    ->delete();
            } else {
                // Atualiza ou cria, apenas se a faixa for da empresa do usuário
                $faixaPertence = \App\Models\FaixasQuantidade::where('id', $faixa['faixa_id'])
                    ->where('empresa_id', $empresaId)
                    ->exists();

                if ($faixaPertence) {
                    ProductPrice::updateOrCreate(
                        [
                            'product_id' => $data['product_id'],
                            'faixa_id' => $faixa['faixa_id'],
                        ],
                        ['price' => $faixa['price']]
                    );
                }
            }
        }

        return response()->json(['message' => 'Preços atualizados com segurança.']);
    }


}
