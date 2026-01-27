<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomingLetter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'index_code',
        'received_date',
        'sender',
        'subject',
        'index_no',
        'category',
        'summary',
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
        'storage_disk',
        'original_filename',
        'file_mime',
        'file_size',
        'gdrive_file_id',
        'gdrive_file_name',
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
