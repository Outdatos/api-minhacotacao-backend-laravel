<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use App\Models\FaixasQuantidade;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function index()
    {
        //
        $products = Product::where('empresa_id', $user->empresa_id);

        return response()->json($products);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
    
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',  // Ensure descricao is a string.
        ]);

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'descricao' => $validated['descricao'],
        ]);

        $faixasQuantidade = FaixasQuantidade::all();

        if ($faixasQuantidade->isEmpty()) {
            return response()->json([
                'message' => 'Não há faixas de quantidades cadastradas.',
            ], 404);
        }

        $pricesData = []; // Array para armazenar os dados de preços
        
        foreach ($faixasQuantidade as $faixa) {
            $pricesData[] = [
                'product_id' => $product->id,
                'faixa_id' => $faixa->id,
                'created_at' => now(), // Don't forget to add timestamps
                'updated_at' => now(),
            ];
        }

        // Inserir todos os preços de uma vez para performance
        ProductPrice::insert($pricesData);

        // Commit da transação
        DB::commit();

        return response()->json([
            'message' => 'Produto criado com sucesso!',
            'product' => $product
        ]);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function show(string $categoryId)
    {
        // Buscar produtos com a categoria correspondente ao categoryId
        $products = Product::with(['category'])
            ->where('category_id', $categoryId) // Filtra por category_id
            ->get();

        return response()->json($products);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function edit(string $id)
    {
       //
    }
    
    public function update(Request $request, string $id)
    {
        //
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'descricao' => 'required|string|max:1000',
        ]);

        $product->update($request->all());

        return response()->json([
            'message' => 'Produto alterado com sucesso',
            'product' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
