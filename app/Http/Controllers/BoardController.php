<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class BoardController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('board.index')
        ->with('users', User::all());
    }
}
