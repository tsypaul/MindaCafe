<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (!auth()->user()->is_admin) {
            return redirect('/');
        }
        return view('components.admin');
    }
}
