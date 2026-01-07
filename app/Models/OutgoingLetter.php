<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingLetter extends Model
{
    protected $fillable = [
        'letter_number',
        'letter_date',
        'recipient',
        'subject',
        'category',
        'summary',
        'status',
        'priority',
        'file_number',
        'instruction_number',
        'package_number',
        'file_path',
        'user_id',
    ];

    protected $casts = [
        'letter_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
