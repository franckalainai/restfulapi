<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerProductController extends APiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        // eager loading
        $products = $buyer->transactions()->with('product')
        ->get()
        ->pluck('product');  // pluck() method to obtain the specific product for each transaction
        return $this->showAll($products);
    }
}
