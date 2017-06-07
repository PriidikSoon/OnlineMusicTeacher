<?php
namespace App\Http\Controllers;

use App\Models\Teacher_student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        $isTeacherStudent = false;
        $teacherStudent = array();
        if($request->input('id'))
        {
            $user = User::find($request->input('id'));
            if($user->type == 'STUDENT')
            {
                $teacher = Auth::user();
                $teacherStudent = Teacher_student::where(['teacher_id' => $teacher->id, 'student_id' => $user->id])->first();
                $returnLink = 'students';
            }else{
                $student = Auth::user();
                $teacherStudent = Teacher_student::where(['teacher_id' => $user->id, 'student_id' => $student->id])->first();
                $returnLink = 'teachers';
            }

            if($request->input('remove')) return $this->removeTeacherStudent($teacherStudent->id, $returnLink);

            $isTeacherStudent = true;
        }else{
            $user = Auth::user();
        }

        $input = array(
            'user' => $user,
            'teacherStudent' => $teacherStudent,
            'isTeacherStudent' => $isTeacherStudent
        );
        return view('profile', $input);
    }

    public function postProfile(Request $request)
    {
        $isTeacherStudent = $request->input('isTeacherStudent');
        if($isTeacherStudent)
        {
            $teacherStudent = Teacher_student::find($request->input('teacherStudentID'));
            $teacherStudent->notes = $request->input('notes');
            $teacherStudent->save();
            return redirect('profile?id=' . $request->input('id'));
        }else {
            $user = User::where('email', Auth::user()->email)->first();
            $user->first_name = $request->input('firstName');
            $user->last_name =$request->input('lastName');
            $user->type = $request->input('type');
            $user->instrument = $request->input('instrument');
            $user->description = $request->input('description');
            $user->save();
            return redirect('profile');
        }
    }

    private function removeTeacherStudent($id, $returnLink)
    {
        Teacher_student::find($id)->delete();
        return redirect($returnLink);
    }
}
