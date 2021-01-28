<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Buyers
 */
Route::Resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);

/**
 * Categories
 */
Route::Resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);

/**
 * Product
 */
Route::Resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);

/**
 * Sellers
 */
Route::Resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);

/**
 * Transactions
 */
Route::Resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);

/**
 * Users
 */
Route::Resource('users', 'User\UserController', ['except' => ['create', 'edit']]);