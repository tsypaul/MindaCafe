<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class LocaleController extends Controller
{
    public function index($lang)
    {
        App::setLocale($lang);
        return view('home');
    }
}
