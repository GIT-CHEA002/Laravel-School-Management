<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_name',
        'code',
    ];

    // Map 'name' attribute to 'subject_name' column
    public function getNameAttribute()
    {
        return $this->attributes['subject_name'] ?? null;
    }
    
    public function setNameAttribute($value)
    {
        $this->attributes['subject_name'] = $value;
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_subject_teacher', 'subject_id', 'school_class_id')
            ->withPivot('teacher_id')
            ->withTimestamps();
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_subject_teacher', 'subject_id', 'teacher_id')
            ->withPivot('school_class_id')
            ->withTimestamps();
    }
}
