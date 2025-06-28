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

    // 🎖️ [Lógica Certificada] //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',  // Ensure descricao is a string.
        ]);

        $product = Product::create($validated);

         return response()->json([
            'message' => 'Produto criado com sucesso!',
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
