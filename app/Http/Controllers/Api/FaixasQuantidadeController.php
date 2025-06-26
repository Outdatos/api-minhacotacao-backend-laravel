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

  public function faixasComProdutos($empresaId)
    {
        $faixas = FaixasQuantidade::with('productPrices')
        ->where('empresa_id', $empresaId)
        ->get();

        return FaixaQuantidadeResource::collection($faixas);
    }
    
}
