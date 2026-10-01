<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    class Meeting extends Model
{
    protected $fillable = [

        'title',
        'meeting_date',
        'meeting_time',
        'venue',
        'agenda',
        'target_type',
        'classroom_id',
        'created_by'
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function guardians()
    {
        return $this->belongsToMany(
            Guardian::class,
            'meeting_guardians'
        )
        ->withPivot(
            'attendance',
            'remarks'
        );
    }
}
