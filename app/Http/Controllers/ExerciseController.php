<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExerciseController extends Controller
{
    public function getExercise(Request $request)
    {
        $exercise = Exercise::find($request->input('id'));
        $input = array(
            'exercise' => $exercise
        );
        return view('exercise', $input);
    }

    public function postExercise(Request $request)
    {
        $exercise = Exercise::find($request->input('id'));
        $exercise->type = $request->input('type');
        $exercise->title = $request->input('title');
        $exercise->author = $request->input('author');
        $exercise->description = $request->input('description');
        $exercise->category = $request->input('category');
        $exercise->tags = $request->input('tags');
        $exercise->save();
        return redirect('exercise?id=' . $request->input('id'));
    }

    public function getAddExercise(Request $request)
    {

        return view('addExercise');
    }

    public function postAddExercise(Request $request)
    {
        $file = $request->file('musicXML');
        $user = Auth::user();
        $file->storeAs('musicXML/' . $user->id, $file->getClientOriginalName());

        if($request->hasFile('recording'))
        {
            $recording = $request->file('recording');
            $recording->storeAs('recording/' . $user->id, $recording->getClientOriginalName());
        }

        $exercise = Exercise::create([
            'user_id' => $user->id,
            'type' => $request->input('type'),
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'description' => $request->input('description'),
            'file_link' => $file->getClientOriginalName(),
            'recording_link' => isset($recording) ? $recording->getClientOriginalName() : null,
            'category' => $request->input('category'),
            'tags' => $request->input('tags')
        ]);

        return redirect('exercise?id=' . $exercise->id);
    }
}
