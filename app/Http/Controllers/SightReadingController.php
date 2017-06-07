<?php
namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Task;
use Illuminate\Http\Request;

class SightReadingController extends Controller
{
    public function getSightReading(Request $request)
    {
        $task = Task::find($request->input('taskID'));
        $task->exercise = Exercise::find($task->exercise_id);
        $input = array(
            'task' => $task
        );
        return view('sightReading', $input);
    }

    public function postSightReading(Request $request)
    {

    }
}