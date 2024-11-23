<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'teacher_id'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    
}
