<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Task;
use App\Models\Teacher_student;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function getTask(Request $request)
    {
        /** @var Task $task */
        $task = Task::find($request->input('id'));

        $task->student = User::find($task->student_id);
        $task->exercise = Exercise::find($task->exercise_id);

        $input = array(
            'task' => $task
        );
        return view('task', $input);
    }

    public function postTask(Request $request)
    {

    }

    public function getAddTask(Request $request)
    {
        $students = array();

        $teacherStudents = Teacher_student::where('teacher_id', Auth::user()->id)->get();
        foreach ($teacherStudents as $teacherStudent) {
            $students[] = User::find($teacherStudent->student_id);
        }

        $exercises = Exercise::where('user_id', Auth::user()->id)->get();


        $input = array(
            'students' => $students,
            'exercises' => $exercises
        );
        return view('addTask', $input);
    }

    public function postAddTask(Request $request)
    {
        $user = Auth::user();
        $task = Task::create([
            'student_id' => $request->input('student'),
            'teacher_id' => $user->id,
            'exercise_id' => $request->input('exercise'),
            'due_date' => $request->input('due_date'),
            'description' => $request->input('description'),
            'status' => 'ASSIGNED'
        ]);

        return redirect('task?id=' . $task->id);
    }
}
