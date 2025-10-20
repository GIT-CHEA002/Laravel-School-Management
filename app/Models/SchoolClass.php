<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_name',
        'teacher_id',
        'room_number',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments', 'class_id', 'student_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject_teacher', 'school_class_id', 'subject_id')
            ->withPivot('teacher_id')
            ->withTimestamps();
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_subject_teacher', 'school_class_id', 'teacher_id')
            ->withPivot('subject_id')
            ->withTimestamps();
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
