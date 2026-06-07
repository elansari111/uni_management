<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'classroom_id',
        'day_of_week',
        'start_time',
        'end_time',
        'type',
    ];

    protected $casts = [
        'start_time' => 'string',
        'end_time' => 'string',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
}
