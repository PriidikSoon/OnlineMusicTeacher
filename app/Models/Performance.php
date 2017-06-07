<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    protected $table = 'performance';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'task_id', 'created_at', 'recording_link', 'accuracy', 'duration', 'preferred'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function task()
    {
        return $this->belongsTo('App\Model\Task', 'task_id');
    }
}