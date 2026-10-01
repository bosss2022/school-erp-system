<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [

        'student_id',

        'from_classroom_id',

        'to_classroom_id',

        'academic_year',

        'promotion_date',

        'promoted_by',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function fromClassroom()
    {
        return $this->belongsTo(Classroom::class, 'from_classroom_id');
    }


    public function toClassroom()
    {
        return $this->belongsTo(Classroom::class, 'to_classroom_id');
    }


    public function promoter()
    {
        return $this->belongsTo(User::class, 'promoted_by');
    }
}