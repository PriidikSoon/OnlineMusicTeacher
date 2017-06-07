<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task';
    public $timestamps = false;

    protected $fillable = [
        'student_id', 'teacher_id', 'exercise_id', 'created_at', 'due_date', 'description', 'grade', 'status'
    ];

    public function teacher()
    {
        return $this->belongsTo('App\User', 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo('App\User', 'student_id');
    }

    public function exercise()
    {
        return $this->belongsTo('App\Models\Exercise', 'exercise_id');
    }
}