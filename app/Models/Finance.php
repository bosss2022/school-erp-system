<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'category',
        'amount',
        'description',
        'recorded_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

     public function student()
{
    return $this->belongsTo(Student::class);
}

}
