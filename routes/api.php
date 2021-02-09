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
Route::Resource('categories.products', 'Category\CategoryProductController', ['only' => ['index']]);
Route::Resource('categories.sellers', 'Category\CategorySellerController', ['only' => ['index']]);
Route::Resource('categories.transactions', 'Category\CategoryTransactionController', ['only' => ['index']]);
Route::Resource('categories.buyers', 'Category\CategoryBuyerController', ['only' => ['index']]);

/**
 * Product
 */
Route::Resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);
Route::Resource('products.transactions', 'Product\ProductTransactionController', ['only' => ['index']]);
Route::Resource('products.buyers', 'Product\ProductBuyerController', ['only' => ['index']]);
Route::Resource('products.categories', 'Product\ProductCategoryController', ['except' => ['create', 'store', 'show', 'edit']]);
Route::Resource('products.buyers.transactions', 'Product\ProductBuyerTransactionController', ['only' => ['store']]);

/**
 * Sellers
 */
Route::Resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);
Route::Resource('sellers.transactions', 'Seller\SellerTransactionController', ['only' => ['index']]);
Route::Resource('sellers.categories', 'Seller\SellerCategoryController', ['only' => ['index']]);
Route::Resource('sellers.buyers', 'Seller\SellerBuyerController', ['only' => ['index']]);
Route::Resource('sellers.products', 'Seller\SellerProductController', ['except' => ['create', 'show', 'edit']]);

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
Route::name('verify')->get('users/verify/{token}', 'User\UserController@verify');
Route::name('resend')->get('users/{user}/resend', 'User\UserController@resend');

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
