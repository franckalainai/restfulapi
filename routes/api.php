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
Route::Resource('buyers.sellers', 'Buyer\BuyerSellerController', ['only' => ['index']]);
Route::Resource('buyers.products', 'Buyer\BuyerProductController', ['only' => ['index']]);
Route::Resource('buyers.categories', 'Buyer\BuyerCategoryController', ['only' => ['index']]);
Route::Resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only' => ['index']]);

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
Route::Resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only' => ['index']]);
Route::Resource('transactions.sellers', 'Transaction\TransactionSellerController', ['only' => ['index']]);

/**
 * Users
 */
Route::Resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
