<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if(!$user->isAdmin()) {
            abort(404);
        }

        return view('localizations.index');
    }
}
