<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductPrice;
use Illuminate\Http\Request;
use App\Models\FaixasQuantidade;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FaixaResource;
use App\Http\Requests\StoreFaixaRequest;
use App\Http\Resources\FaixaQuantidadeResource;

class FaixasQuantidadeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não logado!'], 401);
        }

        $faixas = FaixasQuantidade::where('empresa_id', $user->empresa_id)
            ->orderBy('min_qtd')
            ->orderBy('max_qtd')
            ->get();

        return FaixaResource::collection($faixas);
    }
    
    // 🎖️ [Lógica Certificada] //
    public function store(StoreFaixaRequest $request)
    {
        $user = Auth::user();

        $faixa = FaixasQuantidade::create([
            'empresa_id' => $user->empresa_id,
            'min_qtd'    => $request->input('min_qtd'),
            'max_qtd'    => $request->input('max_qtd'),
        ]);

        return response()->json([
            'message' => 'Faixa criada com sucesso!',
        ], 201);
    }


    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não logado!'], 401);
        }

        $faixa = FaixasQuantidade::find($id);

        if (!$faixa) {
            return response()->json(['message' => 'Faixa não encontrada!'], 404);
        }

        $faixa->delete();

        return response()->json([
            'message' => 'Faixa removida com sucesso!',
            'faixas' => FaixasQuantidade::where('empresa_id', $user->empresa_id)
                ->orderBy('min_qtd')
                ->orderBy('max_qtd')->get(),
        ]);
    }

    // 🎖️ [Lógica Certificada] // Evita o problema 1 + N queries no loop map()
    public function productsWithFaixasPrice($empresaId, $productId)
    {
        $faixas = FaixasQuantidade::where('empresa_id', $empresaId)->orderBy('min_qtd')->get();

        $prices = ProductPrice::where('product_id', $productId)->get()->keyBy('faixa_id');

        $faixasComPreco = $faixas->map(function ($faixa) use ($productId, $prices) {
            $price = $prices->get($faixa->id);

            return [
                'faixa_id' => $faixa->id,
                'min_qtd' => $faixa->min_qtd,
                'max_qtd' => $faixa->max_qtd,
                'empresa_id' => $faixa->empresa_id,
                'product_id' => $productId,
                'price' => $price?->price,
            ];
        });

    return response()->json($faixasComPreco);
    }
    
}
