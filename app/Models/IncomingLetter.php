<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingLetter extends Model
{
    protected $fillable = [
        'index_code',
        'received_date',
        'sender',
        'subject',
        'category',
        'summary',
        'status',
        'letter_date',
        'letter_number',
        'forwarded_to',
        'instruction',
        'final_direction',
        'reference_letter_date',
        'reference_letter_number',
        'instruction_number',
        'package_number',
        'file_path',
        'user_id',
    ];

    protected $casts = [
        'received_date' => 'date',
        'letter_date' => 'date',
        'reference_letter_date' => 'date',
    ];

    /**
     * Get the user that owns the letter.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
