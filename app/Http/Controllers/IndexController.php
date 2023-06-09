<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            setcookie('isAuth', true);
        } else {
            setcookie('isAuth', false);
        }
        return view('index');
    }
}
