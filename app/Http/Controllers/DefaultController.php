<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
        $user_info = Auth::user();

    	return view('html.index')
                ->with('user_info', $user_info);
    }
}
