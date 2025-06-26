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
}
