<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'exercise';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'type', 'title', 'author', 'description', 'file_link', 'recording_link', 'category', 'tags'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}