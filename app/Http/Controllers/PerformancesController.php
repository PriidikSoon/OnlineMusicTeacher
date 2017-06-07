<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerformancesController extends Controller
{
    public function getPerformances(Request $request)
    {

        return view('performances');
    }

    public function postPerformances(Request $request)
    {

    }
}
