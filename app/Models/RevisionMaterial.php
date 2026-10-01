<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevisionMaterial extends Model
{
    protected $fillable = [

    'title',

    'description',

    'file',

    'subject_id',

    'classroom_id',

    'teacher_id',

    'type',

    'uploaded_by',
];



 





    public function subject()
{
    return $this->belongsTo(Subject::class);
}

public function classroom()
{
    return $this->belongsTo(Classroom::class);
}

public function teacher()
{
    return $this->belongsTo(Teacher::class);
}

public function uploader()
{
    return $this->belongsTo(User::class, 'uploaded_by');
}
}
