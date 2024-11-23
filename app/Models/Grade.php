<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'class_id',
        'quarter',
        'grade'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // A grade belongs to a class
    public function class()
    {
        return $this->belongsTo(Section::class);
    }
}
