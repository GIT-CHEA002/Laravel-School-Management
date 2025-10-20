<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'score',
        'grade',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($grade) {
            if ($grade->score !== null && $grade->grade === null) {
                $grade->grade = $grade->calculateGrade($grade->score);
            }
        });
    }

    public function calculateGrade($score)
    {
        if ($score >= 90) return 'A+';
        if ($score >= 80) return 'A';
        if ($score >= 70) return 'B+';
        if ($score >= 60) return 'B';
        if ($score >= 50) return 'C+';
        if ($score >= 40) return 'C';
        if ($score >= 30) return 'D';
        return 'F';
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
