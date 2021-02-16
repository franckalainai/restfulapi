<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use App\Http\Controllers\ApiController;

class SellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::has('products')->get();
        return $this->showAll($sellers);
    }


    public function show(Seller $seller) // <- this is called model binding
        {
        //$seller = Seller::has('products')->findOrFail($id);
        return $this->showOne($seller);
    }

}
