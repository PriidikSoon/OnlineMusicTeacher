<?php

namespace App\Http\Controllers;

use App\Models\Teacher_student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeachersController extends Controller
{
    public function getTeachers(Request $request)
    {
        if($request->input('teacherStudentID') && $request->input('confirm')){
            $teacherStudent = Teacher_student::find($request->input('teacherStudentID'));
            $teacherStudent->confirmed = true;
            $teacherStudent->save();
            return redirect('teachers');
        }
        $teacherStudents = Teacher_student::where('student_id', Auth::user()->id)->get();
        $teachers = array();

        /** @var Teacher_student $student */
        foreach ($teacherStudents as $teacherStudent)
        {
            $teacher = User::find($teacherStudent->teacher_id);
            $teacher->teacherStudentID = $teacherStudent->id;
            $teacher->confirmed = $teacherStudent->confirmed;
            $teachers[] = $teacher;
        }

        $input = array(
            'teachers' => $teachers
        );
        return view('teachers', $input);
    }

    public function postTeachers(Request $request)
    {

    }
}
