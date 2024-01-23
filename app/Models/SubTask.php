<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;
    protected $table = 'sub_task';
    protected $fillable = [
        'task_id',
        'name',
        'description',
        'start_datetime',
        'end_datetime',
        'progress',
        'created_by' 
    ];

    public static function createSubTask($task, $name, $start_datetime ,$end_datetime, $description)
    {
        
        return self::create([
            'task_id' => $task,
            'name' => $name,
            'start_datetime' => $start_datetime,
            'end_datetime' => $end_datetime,
            'description' => $description,
            'created_by'=>auth()->user()->id
        ]);
    }

    public function sub_task_creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }



    
}
