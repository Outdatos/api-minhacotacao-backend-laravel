<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class EmpresaController extends Controller
{
    //
    public function show(Request $request)
    {
        // Obtém o usuário autenticado
        $user = Auth::user();

        // Busca a empresa associada ao usuário relationship
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json(['error' => 'Empresa não encontrada.'], 404);
        }

        return response()->json($empresa);
    }

    public function update(Request $request)
    {
        // Obtém o usuário autenticado
        $user = Auth::user();

        // Busca a empresa associada ao usuário relationship
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json(['error' => 'Empresa não encontrada.'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'cnpj' => 'required|string|min:18|max:18',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|min:15|max:15',
        ]);

        $empresa->update($request->only(['name', 'cnpj', 'email', 'phone_number']));

        return response()->json([
            'empresa' => $empresa,
            'message' => 'Dados atualizados com sucesso.'
        ]);
    }

    public function destroyMasterEmpresas(Request $request, $id)
    {
       $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa não encontrada.'], 404);
        }

        $empresa->delete();

        return response()->json(['message' => 'Empresa excluída com sucesso.']);
    }

    public function showMasterEmpresas(Request $request)
    {
        // Obtém o usuário autenticado
        $user = Auth::user();

        // Busca a empresa associada ao usuário relationship
        $empresa = Empresa::all();

        if (!$empresa) {
            return response()->json(['error' => 'Empresa não encontrada.'], 404);
        }

        return response()->json($empresa);
    }

    public function showMasterUsuarios(Request $request, $empresaId)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não logado!'], 401);
        }

        $empresa = Empresa::find($empresaId);

        if (!$empresa) {
            return response()->json(['error' => 'Empresa não encontrada.'], 404);
        }

        $usuarios = User::where('empresa_id', $empresaId)
                    ->where('role', 'admin')
                    ->get();

        return response()->json([
            'empresa' => $empresa,
            'usuarios' => $usuarios
        ]);
    }

    public function storeMasterEmpresas(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cnpj' => 'required|string|max:20|unique:empresas,cnpj',
            'email' => 'required|email|max:255|unique:empresas,email',
            'phone_number' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $empresa = Empresa::create([
            'name' => $request->name,
            'cnpj' => $request->cnpj,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        return response()->json([
            'message' => 'Empresa cadastrada com sucesso.',
            'empresa' => $empresa
        ], 201);
    }

   public function updateMasterEmpresas(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18|unique:empresas,cnpj,' . $id,
            'email' => 'required|email|unique:empresas,email,' . $id,
            'phone_number' => 'required|string|max:20',
        ]);

        $empresa = Empresa::findOrFail($id);

        $empresa->update($validated);

        return response()->json([
            'message' => 'Empresa atualizada com sucesso!',
            'empresa' => $empresa,
        ]);
    }

    public function updateMasterAdmin(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'required|string|max:20',
        ]);

        $admin = User::findOrFail($id);

        $admin->update($validated);

        return response()->json([
            'message' => 'Administrador(a) atualizada(a) com sucesso!',
            'admin' => $admin,
        ]);
    }

    public function destroyMasterAdmin($id)
    {
        $admin = User::findOrFail($id);

        if (!$admin) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $admin->delete();

        return response()->json([
            'message' => 'Administrador excluído com sucesso!',
            'admin' => $admin
        ]);
    }

}
