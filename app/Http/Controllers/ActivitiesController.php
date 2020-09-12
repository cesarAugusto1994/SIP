<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Auth::user()->activities->sortByDesc('id');
        return view('activities.index', compact('activities'));
    }
}
