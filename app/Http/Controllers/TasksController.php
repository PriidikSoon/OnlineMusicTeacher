<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    public function getTasks(Request $request)
    {
        $user = Auth::user();
        if($user->type == 'STUDENT')
        {
            $userID = 'student_id';
        }else{
            $userID = 'teacher_id';
        }
        $tasks = Task::where($userID, $user->id)->get();

        /** @var Task $task */
        foreach ($tasks as $task)
        {
            $task->exercise = Exercise::find($task->exercise_id);
        }
        $input = array(
            'tasks' => $tasks
        );
        return view('tasks', $input);
    }

    public function postTasks(Request $request)
    {

    }
}
