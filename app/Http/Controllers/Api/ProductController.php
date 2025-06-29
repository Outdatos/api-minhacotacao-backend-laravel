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
    // 🎖️ [Lógica Certificada] //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',  
        ]);

        $product = Product::create($validated);

         return response()->json([
            'message' => 'Produto criado com sucesso!',
        ]);
    }
    
    public function show(string $categoryId)
    {
        $products = Product::with(['category'])
            ->where('category_id', $categoryId)
            ->get();

        return response()->json($products);
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'descricao' => 'required|string|max:1000',
        ]);

        $product->update($request->all());

        return response()->json([
            'message' => 'Produto alterado com sucesso',
        ]);
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
