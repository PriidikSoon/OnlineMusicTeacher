<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taks_comment extends Model
{
    protected $table = 'task_comment';
    public $timestamps = false;

    protected $fillable = [
        'task_id', 'user_id', 'title', 'message', 'created_at'
    ];

    public function teacher()
    {
        return $this->belongsTo('App\User', 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo('App\User', 'student_id');
    }
}