<?php

namespace App\Http\Controllers;

use App\Models\Teacher_student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddStudentController extends Controller
{
    public function getAddStudent(Request $request)
    {
        $input = array();
        if($request->old('error')) $input['error'] = $request->old('error');
        return view('addStudent', $input);
    }

    public function postAddStudent(Request $request)
    {
        $email = $request->input('studentMail');
        $student = User::where('email', $email)->first();

        if($student === null) return redirect('addStudent')->withInput(['error' => 'Could not find user with email ' . $email . '!']);

        $teacherStudent = Teacher_student::create([
            'teacher_id' => Auth::user()->id,
            'student_id' => $student->id,
            'notes' => $request->input('notes')
        ]);
        return redirect('students');
    }
}
