<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getStudent(Request $request)
    {

        return view('student');
    }

    public function postStudent(Request $request)
    {

    }
}
