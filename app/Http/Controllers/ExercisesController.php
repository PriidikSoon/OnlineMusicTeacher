<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExercisesController extends Controller
{
    public function getExercises(Request $request)
    {
        $user = Auth::user();
        $exercises = Exercise::where('user_id', $user->id)->get();
        $input = array(
            'exercises' => $exercises
        );
        return view('exercises', $input);
    }

    public function postExercises(Request $request)
    {

    }
}
