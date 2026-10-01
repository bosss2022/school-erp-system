<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'amount',
        'month',
        'year',
        'payment_date',
        'recorded_by',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
