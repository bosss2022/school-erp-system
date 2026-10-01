<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['name',   'academic_year_id',
'exam_date', 'term'];
     
 protected $casts = [
        'exam_date' => 'date',
    ];
    
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }


    public function academicYear()
{
    return $this->belongsTo(AcademicYear::class);
}


}
