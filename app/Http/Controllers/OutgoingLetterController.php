<?php

namespace App\Http\Controllers;

use App\Models\OutgoingLetter;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OutgoingLetterController extends Controller
{
    public function __construct(
        protected GoogleDriveService $googleDrive
    ) {}
    public function index(Request $request)
    {
        $query = OutgoingLetter::query()->latest('letter_date');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('letter_number', 'like', '%' . $search . '%')
                    ->orWhere('subject', 'like', '%' . $search . '%')
                    ->orWhere('recipient', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('month')) {
            $month = $request->input('month'); // Format: YYYY-MM
            $query->whereYear('letter_date', substr($month, 0, 4))
                ->whereMonth('letter_date', substr($month, 5, 2));
        }

        $letters = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => OutgoingLetter::count(),
            'pending' => OutgoingLetter::where('status', 'Menunggu')->count(),
            'sent' => OutgoingLetter::whereIn('status', ['Terkirim', 'Selesai'])->count(),
        ];

        $statusOptions = ['Menunggu', 'Diproses', 'Terkirim', 'Selesai'];

        return view('surat-keluar.index', compact('letters', 'stats', 'statusOptions'));
    }

    public function create(Request $request)
    {
        if (!$request->user()->hasAnyRole(['sekretariat', 'admin'])) {
            abort(403);
        }

        return view('tambah-surat-keluar');
    }

    public function store(Request $request)
    {
        if (!$request->user()->hasAnyRole(['sekretariat', 'admin'])) {
            abort(403);
        }

        $data = $request->validate([
            'letter_number' => ['required', 'string', 'max:100'],
            'recipient' => ['required', 'string', 'max:255'],
            'letter_date' => ['required', 'date'],
            'subject' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'summary' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:Menunggu,Diproses,Terkirim,Selesai'],
            'priority' => ['nullable', 'string', 'in:Biasa,Penting,Rahasia'],
            'file_number' => ['nullable', 'string', 'max:100'],
            'instruction_number' => ['nullable', 'string', 'max:100'],
            'package_number' => ['nullable', 'string', 'max:100'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:20480'],
        ]);

        $data['status'] = $data['status'] ?? 'Menunggu';
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFilename = $file->getClientOriginalName();
            $mimeType = $file->getMimeType();
            $fileSize = $file->getSize();

            // TEMPORARILY DISABLED: Google Drive upload untuk presentasi
            // Uncomment blok di bawah ini untuk mengaktifkan kembali Google Drive
            /*
            // Coba upload ke Google Drive terlebih dahulu
            if ($this->googleDrive->isConfigured()) {
                try {
                    $gdriveResult = $this->googleDrive->uploadFile($file);

                    if ($gdriveResult) {
                        $data['gdrive_file_id'] = $gdriveResult['id'];
                        $data['gdrive_file_name'] = $gdriveResult['name'];
                        $data['original_filename'] = $originalFilename;
                        $data['file_mime'] = $mimeType;
                        $data['file_size'] = $fileSize;
                        $data['storage_disk'] = 'google_drive';
                    } else {
                        // Upload gagal, fallback ke local
                        $this->storeFileLocally($file, $data);
                    }
                } catch (\Exception $e) {
                    // Fallback ke local storage jika Google Drive gagal
                    \Log::warning('Google Drive upload failed, falling back to local storage: ' . $e->getMessage());
                    $this->storeFileLocally($file, $data);
                }
            } else {
                // Local storage jika Google Drive tidak dikonfigurasi
                $this->storeFileLocally($file, $data);
            }
            */

            // Sementara langsung simpan ke local storage
            $this->storeFileLocally($file, $data);
        }

        OutgoingLetter::create($data);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil disimpan.');
    }

    public function show(OutgoingLetter $outgoingLetter)
    {
        $attachment = $this->buildAttachment($outgoingLetter);

        return view('detail-surat-keluar', compact('outgoingLetter', 'attachment'));
    }

    public function edit(Request $request, OutgoingLetter $outgoingLetter)
    {
        if (!$request->user()->hasAnyRole(['sekretariat', 'admin'])) {
            abort(403);
        }

        $attachment = $this->buildAttachment($outgoingLetter);

        return view('edit-surat-keluar', compact('outgoingLetter', 'attachment'));
    }

    public function update(Request $request, OutgoingLetter $outgoingLetter)
    {
        if (!$request->user()->hasAnyRole(['sekretariat', 'admin'])) {
            abort(403);
        }

        $data = $request->validate([
            'letter_number' => ['required', 'string', 'max:100'],
            'recipient' => ['required', 'string', 'max:255'],
            'letter_date' => ['required', 'date'],
            'subject' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'summary' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:Menunggu,Diproses,Terkirim,Selesai'],
            'priority' => ['nullable', 'string', 'in:Biasa,Penting,Rahasia'],
            'file_number' => ['nullable', 'string', 'max:100'],
            'instruction_number' => ['nullable', 'string', 'max:100'],
            'package_number' => ['nullable', 'string', 'max:100'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:20480'],
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Hapus file lama jika ada
            if ($outgoingLetter->file_path) {
                $oldDisk = Storage::disk($outgoingLetter->storage_disk ?? $this->lettersDiskName());
                if ($oldDisk->exists($outgoingLetter->file_path)) {
                    $oldDisk->delete($outgoingLetter->file_path);
                }
            }

            // Simpan file baru ke local storage
            $this->storeFileLocally($file, $data);
        }

        $outgoingLetter->update($data);

        return redirect()->route('detail-surat-keluar', $outgoingLetter)
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function download(OutgoingLetter $outgoingLetter)
    {
        // Jika file disimpan di Google Drive
        if ($outgoingLetter->gdrive_file_id) {
            $downloadUrl = $this->googleDrive->getDownloadUrl($outgoingLetter->gdrive_file_id);
            return redirect()->away($downloadUrl);
        }

        // Fallback ke local storage
        $diskName = $outgoingLetter->storage_disk ?? $this->lettersDiskName();
        $disk = Storage::disk($diskName);

        if (!$outgoingLetter->file_path || !$disk->exists($outgoingLetter->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return $this->streamDownload($disk, $outgoingLetter->file_path);
    }

    public function preview(OutgoingLetter $outgoingLetter)
    {
        // Jika file disimpan di Google Drive
        if ($outgoingLetter->gdrive_file_id) {
            $previewUrl = $this->googleDrive->getPreviewUrl($outgoingLetter->gdrive_file_id);
            return redirect()->away($previewUrl);
        }

        // Fallback ke local storage
        $diskName = $outgoingLetter->storage_disk ?? $this->lettersDiskName();
        $disk = Storage::disk($diskName);

        if (!$outgoingLetter->file_path || !$disk->exists($outgoingLetter->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $mimeType = $outgoingLetter->file_mime ?? 'application/octet-stream';
        $stream = $disk->readStream($outgoingLetter->file_path);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . ($outgoingLetter->original_filename ?? basename($outgoingLetter->file_path)) . '"',
        ]);
    }

    private function buildAttachment(OutgoingLetter $letter): ?array
    {
        // Jika file di Google Drive
        if ($letter->gdrive_file_id) {
            return [
                'name' => $letter->gdrive_file_name ?? $letter->original_filename ?? 'File',
                'size' => $this->formatBytes($letter->file_size ?? 0),
                'url' => route('surat-keluar.download', $letter),
                'preview_url' => $this->googleDrive->getPreviewUrl($letter->gdrive_file_id),
                'view_url' => $this->googleDrive->getViewUrl($letter->gdrive_file_id),
                'is_gdrive' => true,
                'mime_type' => $letter->file_mime,
            ];
        }

        // Fallback ke local storage
        $path = $letter->file_path;
        if (!$path) {
            return null;
        }

        $disk = Storage::disk($letter->storage_disk ?? $this->lettersDiskName());
        if (!$disk->exists($path)) {
            return null;
        }

        $size = $this->safeSize($disk, $path);

        return [
            'name' => $letter->original_filename ?? basename($path),
            'size' => $this->formatBytes($size),
            'url' => route('surat-keluar.download', $letter),
            'preview_url' => route('surat-keluar.preview', $letter),
            'is_gdrive' => false,
            'mime_type' => $letter->file_mime,
        ];
    }

    private function storeFileLocally($file, array &$data): void
    {
        $disk = $this->lettersDiskName();
        $path = $file->store('outgoing_letters', $disk);

        $data['file_path'] = $path;
        $data['storage_disk'] = $disk;
        $data['original_filename'] = $file->getClientOriginalName();
        $data['file_mime'] = $file->getMimeType();
        $data['file_size'] = $file->getSize();
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = (int) floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
    }

    private function lettersDiskName(): string
    {
        return config('filesystems.letters_disk', 'public');
    }

    private function lettersDisk()
    {
        return Storage::disk($this->lettersDiskName());
    }

    private function safeSize($disk, string $path): int
    {
        try {
            return $disk->size($path);
        } catch (\Throwable $exception) {
            return 0;
        }
    }

    private function streamDownload($disk, string $path)
    {
        $stream = $disk->readStream($path);
        if (!$stream) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return response()->streamDownload(function () use ($stream) {
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, basename($path));
    }
}
