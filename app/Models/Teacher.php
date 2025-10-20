<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'photo_url',
        'address',
        'first_name',
        'last_name',
        'specialization',
        'hire_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_subject_teacher')
            ->withPivot('subject_id')
            ->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject_teacher')
            ->withPivot('school_class_id')
            ->withTimestamps();
    }
}
