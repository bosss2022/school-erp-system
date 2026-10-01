<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingGuardian extends Model
{
 protected $fillable = [

        'meeting_id',
        'guardian_id',
        'attendance',
        'remarks'
    ];

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}

