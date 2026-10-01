<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'amount_paid',
        'academic_year_id',
        'total_fee',
        'balance',
        'term',
        'payment_date',
        'recorded_by',
    ];

    protected $casts = [
    'payment_date' => 'datetime',
];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function academicYear()
{
    return $this->belongsTo(AcademicYear::class);
}
}
