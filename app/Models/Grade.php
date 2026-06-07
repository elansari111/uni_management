<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'module_id',
        'cc1',
        'cc2',
        'exam',
        'final_grade',
        'remarks',
    ];

    protected $casts = [
        'cc1' => 'decimal:2',
        'cc2' => 'decimal:2',
        'exam' => 'decimal:2',
        'final_grade' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
