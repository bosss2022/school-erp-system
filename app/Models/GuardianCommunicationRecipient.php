<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardianCommunicationRecipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'guardian_communication_id',
        'guardian_id',
        'email',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function communication()
    {
        return $this->belongsTo(GuardianCommunication::class);
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }
}