<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Archive extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'jenis',
        'pengirim',
        'penerima',
        'perihal',
        'ringkasan',
        'file_path',
        'storage_disk',
        'original_filename',
        'file_mime',
        'file_size',
        'drive_file_id',
        'drive_web_view_link',
        'folder',
        'tags',
        'status',
    ];

    protected $dates = [
        'tanggal_surat',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'tanggal_surat' => 'date',
    ];

    // --- AUTOMATION & EVENTS ---

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });

        // Hapus file fisik otomatis saat data di-Force Delete (Hapus Permanen)
        // Ini menjaga storage tetap bersih dan hemat.
        static::forceDeleted(function ($archive) {
            if ($archive->file_path && Storage::disk($archive->storage_disk ?? 'public')->exists($archive->file_path)) {
                Storage::disk($archive->storage_disk ?? 'public')->delete($archive->file_path);
            }
        });
    }

    // --- SCOPES (Pencarian Cerdas) ---

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('nomor_surat', 'like', '%' . $search . '%')
                    ->orWhere('perihal', 'like', '%' . $search . '%')
                    ->orWhere('pengirim', 'like', '%' . $search . '%')
                    ->orWhere('penerima', 'like', '%' . $search . '%')
                    ->orWhere('ringkasan', 'like', '%' . $search . '%')
                    ->orWhere('original_filename', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['jenis'] ?? false, function ($query, $jenis) {
            $query->where('jenis', $jenis);
        });

        $query->when($filters['folder'] ?? false, function ($query, $folder) {
            $query->where('folder', $folder);
        });
    }

    // --- ACCESSORS (Helper Tampilan) ---

    // Mengambil ukuran file yang sudah diformat (KB/MB) otomatis
    // Pemanggilan: $archive->formatted_size
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes <= 0) return '0 B';
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes, 1024));
        
        return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
    }

    // Menentukan icon file berdasarkan mime type (misal untuk UI)
    // Pemanggilan: $archive->file_icon
    public function getFileIconAttribute()
    {
        $mime = $this->file_mime;

        if (Str::contains($mime, 'pdf')) return 'pdf';
        if (Str::contains($mime, ['image', 'jpg', 'jpeg', 'png'])) return 'image';
        if (Str::contains($mime, ['word', 'document'])) return 'word';
        if (Str::contains($mime, ['sheet', 'excel', 'spreadsheet'])) return 'excel';
        
        return 'file'; // Default
    }
    
    // Helper untuk cek apakah file ada di storage
    public function hasFile()
    {
        return $this->file_path && Storage::disk($this->storage_disk ?? 'public')->exists($this->file_path);
    }
}