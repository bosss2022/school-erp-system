<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardianCommunication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subject',
        'message',
        'type',
        'recipient_type',
        'classroom_id',
        'created_by',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function recipients()
    {
        return $this->hasMany(GuardianCommunicationRecipient::class);
    }
}