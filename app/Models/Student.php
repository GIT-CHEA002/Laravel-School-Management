<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_code',
        'first_name',
        'last_name',
        'gender',
        'dob',
        'address',
        'phone',
        'photo_url',
        'parent_name',
        'parent_phone',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    // Accessor for age calculation
    public function getAgeAttribute()
    {
        return $this->dob ? $this->dob->age : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'enrollments', 'student_id', 'class_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
