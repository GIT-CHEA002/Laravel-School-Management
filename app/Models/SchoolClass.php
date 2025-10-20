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
        return $this->belongsToMany(Student::class, 'enrollments');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject_teacher')
            ->withPivot('teacher_id')
            ->withTimestamps();
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_subject_teacher')
            ->withPivot('subject_id')
            ->withTimestamps();
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
