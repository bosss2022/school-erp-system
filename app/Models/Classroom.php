<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = ['name',  'capacity','teacher_id'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

public function teacher()
{
    return $this->belongsTo(\App\Models\Teacher::class, 'teacher_id');
}
 
public function subjects()
{
    return $this->hasMany(\App\Models\Subject::class);
}

public function feeStructures()
{
    return $this->hasMany(FeeStructure::class);
}

}
