<?php

namespace App\Providers;

use App\Buyer;
use App\Seller;
use App\User;
use App\Transaction;
use Carbon\Carbon;
use App\Policies\BuyerPolicy;
use App\Policies\SellerPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\UserPolicy;
use App\Product;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        Buyer::class => BuyerPolicy::class,
        Seller::class => SellerPolicy::class,
        User::class => UserPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Product::class => Product::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-action', function($user){
            return $user->isAdmin();
        });

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();
        Passport::tokensCan([
            'purchase-product' => 'Create a new transaction for a specific product',
            'manage-products' => 'Creat, Read, Update, Delete products (CRUD)',
            'manage-account' => 'Read your account data, id,name, email, if verified, if admin,(cannot modify password), modify your account data (email and password), cannot delete your account',
            'read-general' => 'Read general information like purchasing categories, purchased products, selling categories,your transactions (purchases and sales)'
        ]);
    }
}
