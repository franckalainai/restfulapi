<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getTokens(){
      return view('home/personal-tokens');
    }

    public function getClients(){
        return View('home/personal-clients');
    }

    public function getAuthorizedClients(){
        return view('home/authorized-clients');
    }
}
