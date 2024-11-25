<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'class_id',
        'user_id'
    ];


    public function section()
    {
        return $this->belongsTo(Section::class, 'class_id');
    }

    // In Student.php model
    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
