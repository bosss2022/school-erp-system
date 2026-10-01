<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeStructureDocument extends Model
{
    protected $fillable = [

        'academic_year_id',

        'file',

    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}