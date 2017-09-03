<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefaultController extends Controller
{
    //Default validation
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Get homepage with template
    public function index()
    {
    	return view('themes.default');
    }
}
