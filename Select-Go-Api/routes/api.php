<?php

use App\Http\Controllers\ImagesController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;


// ====================================================================================
//   ================================================================================

//       █████╗ ██████╗ ██╗    ██████╗  ██████╗ ██╗   ██╗████████╗███████╗███████╗
//      ██╔══██╗██╔══██╗██║    ██╔══██╗██╔═══██╗██║   ██║╚══██╔══╝██╔════╝██╔════╝
//      ███████║██████╔╝██║    ██████╔╝██║   ██║██║   ██║   ██║   █████╗  ███████╗
//      ██╔══██║██╔═══╝ ██║    ██╔══██╗██║   ██║██║   ██║   ██║   ██╔══╝  ╚════██║
//      ██║  ██║██║     ██║    ██║  ██║╚██████╔╝╚██████╔╝   ██║   ███████╗███████║
//      ╚═╝  ╚═╝╚═╝     ╚═╝    ╚═╝  ╚═╝ ╚═════╝  ╚═════╝    ╚═╝   ╚══════╝╚══════╝

//   ================================================================================
// ====================================================================================

// * Default
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ==================================
// * 驗證 APIs
// ==================================
Route::post('/register', [AuthController::class, 'register']);
// same as 'App\Http\Controllers\AuthController@register'
Route::post('/login', [AuthController::class, 'login']);
// get user info based on user ID(need to login before access)
Route::get('/user/list', [AuthController::class, 'listAllUsers']);
Route::get('/singleUserData/{id}', [AuthController::class, 'singleUserData']);

// ==================================
// * 使用者 APIs
// ==================================
Route::put('/user/update', [AuthController::class, 'updateUser']);

// ==================================
// 產品 APIs 
// ==================================
// 新增商品
Route::post('/product/add', [ProductsController::class, 'addProduct']);
// 刪除商品
Route::delete('/product/delete/{id}', [ProductsController::class, 'deleteProduct']);
// 更新商品
Route::put('/product/update/{id}', [ProductsController::class, 'updateProduct']);
// 所有商品資料
// Route::get('/product/list', [ProductsController::class, 'list']);
Route::get('/product/list', [ProductsController::class, 'list']);
// 查看單一筆
Route::get('/product/{id}', [ProductsController::class, 'getProduct']);
// 搜尋
Route::get('/search/{key}', [ProductsController::class, 'search']);
// Find products based on userID
Route::get('/findUserProduct/{id}', [ProductsController::class, 'findUserProduct']);

// ==================================
// 圖片 APIs 
// ==================================
Route::post('/imgs/add', [ImagesController::class, 'store']);
Route::post('/imgs/list', [ImagesController::class, 'index']);

// ==================================================================================================
// * 受保護路徑  -> need to login first to access
// ==================================================================================================
Route::group(['middleware' => 'api'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});