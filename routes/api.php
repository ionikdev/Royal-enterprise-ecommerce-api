<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EcommerceApiControllers\CartController;
use App\Http\Controllers\EcommerceApiControllers\CategoryController;
use App\Http\Controllers\EcommerceApiControllers\FrontendController;
use App\Http\Controllers\EcommerceApiControllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

//  Frontend fetch
Route::get('/get-category',[FrontendController::class, 'category']);
Route::get('/fetchproducts/{slug}',[FrontendController::class, 'product']); 
Route::get('/view-product/{category_slug}/{product_slug}',[FrontendController::class, 'viewproduct']);
Route::post('/add-to-cart',[CartController::class, 'addtocart']); 
Route::get('/cart',[CartController::class, 'viewcart']); 
Route::put('/cart-updatequantity/{cart_id}/{scope}',[CartController::class, 'updatequantity']); 
Route::delete('/delete-cartitem/{cart_id}/delete',[CartController::class, 'deletecartitem']); 


// protected route
Route::group(['middleware' => ['auth:sanctum', 'isAPIAdmin']], function () {
    Route::get('/checkingAuthenticated', function () {
        return response()->json(['message' => 'You are in']);
    });
    // Category
    Route::get('/view-categories', [CategoryController::class, 'index']);
    Route::get('/all-categories', [CategoryController::class, 'allcategory']);
    Route::post('store-categories', [CategoryController::class, 'store']);
    Route::get('category/{id}/edit', [CategoryController::class, 'edit']);
    Route::put('category/{id}/edit', [CategoryController::class, 'update']);
    Route::delete('category/{id}/delete', [CategoryController::class, 'destory']);

    //Products
    
    Route::get('view-products', [ProductController::class, 'index']);
    Route::post('store-product', [ProductController::class, 'store']);
    Route::get('products/{id}/edit', [ProductController::class, 'edit']);
    Route::post('products/{id}/edit', [ProductController::class, 'update']);

});


// protected route
Route::group(['middleware' => ['auth:sanctum']], function () {

Route::post('/logout', [AuthController::class, 'logout']);
});