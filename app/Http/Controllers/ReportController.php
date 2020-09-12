<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report\Report;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::paginate();
        return view('reports.index', compact('reports'));
    }
}
