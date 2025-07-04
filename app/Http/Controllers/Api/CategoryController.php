<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Http\Resources\CategoryWithProductsResource;
use App\Http\Resources\ProductWithPricesResource;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $categories = Category::where('empresa_id', $user->empresa_id)->get();

        return response()->json($categories);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $category = Category::create([
            'name' => $request->name,
            'empresa_id' => $user->empresa_id,
        ]);

        return response()->json([
            'message' => 'Categoria criada com sucesso',
            'category' => $category
        ]);
    }

    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category->update($request->all());

        return response()->json([
            'message' => 'Categoria atualizada com sucesso',
            'category' => $category
        ]);
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }

    
    // 🎖️ [Lógica Certificada] //
    public function indexProducts($categoryId)
    {
        $category = Category::with('products')->find($categoryId);

        if (!$category) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }

        return new CategoryWithProductsResource($category);
    }

    // 🎖️ [Lógica Certificada] //
    public function showFaixasProduct($categoryId, $productId)
    {
        $empresaId = auth()->user()->empresa_id;

        $product = Product::with(['category', 'prices.faixa'])
            ->where('category_id', $categoryId)
            ->where('id', $productId)
            ->where('empresa_id', $empresaId) // ✅ garante que pertence à empresa
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado nesta categoria ou não pertence à sua empresa'], 404);
        }

        return new ProductWithPricesResource($product);
    }
}
