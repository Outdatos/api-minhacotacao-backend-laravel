<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\AdditionalItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AdditionalItemResource;

class AdditionalItemsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if(!$user) {
            return response()->json(['message' => 'Usuário não logado!'], 401);
        }

        $items = AdditionalItem::where('empresa_id', $user->empresa_id)
                    ->orderBy('descricao', 'asc')
                    ->get();

        return AdditionalItemResource::collection($items);
    }

    public function create()
    {
         //
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if(!$user) {
            return response()->json(['message' => 'Usuário não logado!'], 401);
        }

        $request->validate([
            'descricao' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);
    
        // Cria o novo item
        $item = AdditionalItem::create([
            'descricao' => $request->descricao,
            'price' => $request->price,
            'empresa_id' => $user->empresa_id,
        ]);
    
        // Retorna todos os itens ordenados alfabeticamente pela coluna 'descricao'
        $itens = AdditionalItem::where('empresa_id', $user->empresa_id)
            ->orderBy('descricao', 'asc')
            ->get();
    
        return response()->json([
            'message' => 'Item criado com sucesso',
            'itens' => $itens
        ], 201);
    }
    
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $itemId)
    {
        //
        $item = AdditionalItem::findOrFail($itemId);

        $request->validate([
            'descricao' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $item->update($request->all());

        return response()->json([
            'message' => 'Item alterado!',
            'item' => $item
        ]);
    }

    public function destroy(string $itemId)
    {
        //
        $item = AdditionalItem::findOrFail($itemId);
        $item->delete();

        return response()->json(['message' => 'Item deletado!']);
    }
}
