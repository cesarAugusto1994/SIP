<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Client,Documents};

class ClientDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->filled('client')) {
            return back();
        }

        $client = Client::uuid($request->get('client'));

        return view('clients.documents.index', compact('client'));
    }
}
