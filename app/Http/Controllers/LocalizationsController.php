<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationsController extends Controller
{
    public function index(Request $request)
    {
        return view('localizations.index');
    }
}
