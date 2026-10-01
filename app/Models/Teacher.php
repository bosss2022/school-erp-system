<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'photo',
        'password',
         'user_id', 
    ];

public function classrooms()
{
    return $this->hasMany(\App\Models\Classroom::class, 'teacher_id');
}
public function subjects()
{
    return $this->hasMany(Subject::class);
}


  
public function user()
{
    return $this->belongsTo(User::class);
}

public function salary()
{
    return $this->hasOne(\App\Models\TeacherSalary::class, 'teacher_id');
}


}
