<?php

namespace App\Http\Controllers;

use App\Models\Teacher_student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentsController extends Controller
{
    public function getStudents(Request $request)
    {
        $teacherStudents = Teacher_student::where('teacher_id', Auth::user()->id)->get();
        $students = array();

        /** @var Teacher_student $student */
        foreach ($teacherStudents as $teacherStudent)
        {
            $student = User::find($teacherStudent->student_id);
            $student->notes = $teacherStudent->notes;
            $student->confirmed = $teacherStudent->confirmed;
            $students[] = $student;
        }

        $input = array(
            'students' => $students
        );
        return view('students', $input);
    }

    public function postStudents(Request $request)
    {

    }
}
