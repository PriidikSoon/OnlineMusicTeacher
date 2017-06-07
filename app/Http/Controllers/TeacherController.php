<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function getTeacher(Request $request)
    {

        return view('teacher');
    }

    public function postTeacher(Request $request)
    {

    }
}
