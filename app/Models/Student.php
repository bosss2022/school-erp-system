<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Guardian;


class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_no', 'first_name', 'last_name', 'dob', 'gender',
        'email', 'phone',   'address', 'classroom_id','photo','guardian_id','user_id','academic_year',
    ];

    protected $casts = [
       
        'dob' => 'date',
    ];

  


    // Relationships
    public function klass() {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    

    public function classroom()
{
   return $this->belongsTo(Classroom::class, 'classroom_id');
}

public function user()
{
    return $this->belongsTo(User::class);
}
 public function marks() {
    return $this->hasMany(Mark::class);
}
public function guardian()
{
  return $this->belongsTo(Guardian::class, 'guardian_id', 'id');
}

public function payments()
{
    return $this->hasMany(StudentPayment::class, 'student_id');
} 
 
public function attendances()
{
    return $this->hasMany(Attendance::class);
}
}
