<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher_student extends Model
{
    protected $table = 'teacher_student';
    public $timestamps = false;

    protected $fillable = [
        'teacher_id', 'student_id', 'notes', 'created_at', 'confirmed'
    ];

    public function teacher()
    {
        return $this->belongsTo('App\User','teacher_id');
    }

    public function student()
    {
        return $this->belongsTo('App\User', 'student_id');
    }
}