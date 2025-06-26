<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Index Users
     */
    public function index()
    {
        $user = Auth::user();

        if(!$user){
            return reponse()->json(['message' => 'Usuário não logado!'], 401);
        }

        $vendedores = User::where('empresa_id', $user->empresa_id)
            ->where('id', '!=', $user->id)
            ->orderByRaw('role = "admin" desc')  
            ->orderBy('name', 'asc')             
            ->get();

        return response()->json($vendedores);
    }

    /**
     * Show user
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
            if (!$user) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }
        return response()->json($user);
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }

        // Inclui a relação 'empresa' no usuário
        $user = User::with('empresa')->find($user->id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20',
            'password' => 'nullable|string|min:6|max:20|confirmed',
        ]);

        // Atualiza os dados do usuário
        $user->fill($validatedData);

        // Se a senha foi informada, altera
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json([
            'user' => UserResource::make($user),
            'message' => 'Perfil atualizado com sucesso', 
        ]);
    }

    /**
     * Store new user
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
    
        return response()->json([
            'message' => 'Usuário criado com sucesso',
            'user' => $user
        ]);
    }

     /**
     * Deletar Users
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);


        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuário excluído com sucesso!',
            'user' => $user
        ]);
    }
    
    /**
     *  Login User
     */
    public function auth(AuthUserRequest $request)
    {
        if($request->validated()) {
            $user = User::with('empresa')->whereEmail($request->email)->first();
            if(!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'error' => 'Credenciais inválidas'
                ]);
            }else {
                return response()->json([
                    'user' => UserResource::make($user),
                    'access_token' => $user->createToken('new_user')->plainTextToken,
                    'message' => 'Login realizado com sucesso'
                ]);
            }
        }
    }

    /**
     * Logout the user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Desconectado com sucesso'
        ]);
    }

    /**
     * Update User Role
     */
    public function updateRole(Request $request, $id)
    {
        // Validações (caso necessário)
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        // Encontra o usuário
        $user = User::findOrFail($id);

        // Atualiza o campo 'role' do usuário
        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'Permissão atualizada!']);
    }

    public function UpdateUserProfile(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user->update($validatedData);

        return response()->json([
            'message' => 'Perfil atualizado com sucesso!',
            'user' => $user
        ]);
    }

    public function updateAdminToUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'required|string|max:20',
        ]);

        $user->update($validatedData);

        return response()->json([
            'message' => 'Usuário atualizado com sucesso!',
            'user' => $user
        ]);
    }
}
