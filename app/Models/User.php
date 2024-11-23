<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

 
use Illuminate\Database\Eloquent\Casts\Attribute;
 
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type'
    ];

    protected $hidden = [
        'password'
    ];
 
    protected function type(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  ["student", "teacher", "registrar", "admin"][$value],
        );
    }

    public function classes()
    {
        return $this->hasMany(Section::class, 'teacher_id');
    }

    // Define the class relationship for a student
    public function studentClasses()
    {
        return $this->belongsToMany(Section::class, 'students', 'user_id', 'class_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'teacher_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

}