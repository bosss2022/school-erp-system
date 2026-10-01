<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = [

        'name',

        'start_date',

        'end_date',

        'is_current',

    ];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

  public function feeStructures()
{
    return $this->hasMany(FeeStructure::class);
}

}


