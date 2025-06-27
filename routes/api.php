<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdditionalItemsController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\FaixasQuantidadeController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductPriceController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PDFController;
use App\Http\Resources\UserResource;
use App\Models\FaixasQuantidade;


Route::middleware('auth:sanctum')->group(function() {
    Route::get('user', function(Request $request) {
        return [
            'user' => UserResource::make($request->user()),
            'access_token' => $request->bearerToken()
        ];
    });
// 
// 🔐 Rotas acessíveis para todos os usuários autenticados (user/admin)
    

    

    //Vendedores
    Route::post('user/register', [UserController::class, 'store']);
    Route::get('users-list', [UserController::class, 'index']);
    Route::get('user-show/{id}', [UserController::class, 'show']);
    Route::put('user-update', [UserController::class, 'update']);
    Route::put('user-update/admin-to-user/{id}', [UserController::class, 'updateAdminToUser']);
    Route::delete('users-list/{id}', [UserController::class, 'destroy']);
    Route::post('user/logout', [UserController::class, 'logout']);

    //Product Routes
    Route::apiResource('products', ProductController::class);

    //Empresa
    Route::get('empresa', [EmpresaController::class, 'show']);
    Route::put('empresa', [EmpresaController::class, 'update']);


    //Master: empresas
    Route::get('empresas', [EmpresaController::class, 'showMasterEmpresas']);
    Route::get('empresas/usuarios/{empresaId}', [EmpresaController::class, 'showMasterUsuarios']);
    Route::post('empresas', [EmpresaController::class, 'storeMasterEmpresas']);
    Route::put('empresas-update/{id}', [EmpresaController::class, 'updateMasterEmpresas']);
    Route::delete('empresas/{id}', [EmpresaController::class, 'destroyMasterEmpresas']);
    Route::put('admin-update/{id}', [EmpresaController::class, 'updateMasterAdmin']);
    Route::delete('admin-delete/{id}', [EmpresaController::class, 'destroyMasterAdmin']);


  ////////////////////////////////////////////////////////////////////////////////////////////////////

    // Categories [crud]
    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

    // Categories e Products [process]
    Route::get('categories/{categoryId}/products', [CategoryController::class, 'indexProducts']);
    Route::get('categories/{categoryId}/products/{productId}', [CategoryController::class, 'showProduct']);
   
    // Items [crud]
    Route::get('itens-adicionais', [AdditionalItemsController::class, 'index'] );
    Route::post('itens-adicionais', [AdditionalItemsController::class, 'store'] );
    Route::put('itens-adicionais/{itemId}', [AdditionalItemsController::class, 'update'] );
    Route::delete('itens-adicionais/{itemId}', [AdditionalItemsController::class, 'destroy'] );

    // Faixas [crud]
    Route::get('/faixas-quantidade', [FaixasQuantidadeController::class, 'index']);
    Route::post('/faixas-quantidade', [FaixasQuantidadeController::class, 'store']);
    Route::delete('/faixas-quantidade/{id}', [FaixasQuantidadeController::class, 'destroy']);

    //Product Prices

    Route::post('/product-prices/store-or-update', [ProductPriceController::class, 'storeOrUpdate']);
    Route::get('/empresa/{empresaId}/faixas-com-produtos/{productId}/product-faixas', [FaixasQuantidadeController::class, 'productsWithFaixasPrice']);

  ////////////////////////////////////////////////////////////////////////////////////////////////////



     // 🔐🔑 Rotas acessíveis apenas para administradores
    Route::middleware('admin')->group(function () {
        Route::put('/users/{id}/role', [UserController::class, 'updateRole']);
    });

});

//Login User
Route::post('user/login', [UserController::class, 'auth']);

Route::post('/gerar-pdf', [PDFController::class, 'gerar']);





    Route::get('product-prices', [ProductPriceController::class, 'index']);
    Route::post('product-prices', [ProductPriceController::class, 'store']);
    Route::get('product-prices/{productId}', [ProductPriceController::class, 'show']);
    Route::post('product-prices/save', [ProductPriceController::class, 'saveProductPrices']);


// routes/api.php
























// // Rotas protegidas por autenticação JWT
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/user/profile', [UserController::class, 'profile']);
    
//     // Apenas admins podem acessar estas rotas
//     Route::middleware('admin')->group(function () {

        
//         Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);


//     });
    
//     Route::post('/logout', [AuthController::class, 'logout']);
// });

























