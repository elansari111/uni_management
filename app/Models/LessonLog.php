<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'module_id',
        'classroom_id',
        'date',
        'start_time',
        'end_time',
        'title',
        'summary',
        'objective',
        'nature',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'string',
        'end_time' => 'string',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
