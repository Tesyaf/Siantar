<?php

namespace App\Http\Controllers;

use App\Models\IncomingLetter;
use App\Models\User;
use App\Notifications\IncomingLetterCreated;
use App\Services\GoogleDriveService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class IncomingLetterController extends Controller
{
    public function __construct(
        protected GoogleDriveService $googleDrive
    ) {}
    public function index(Request $request)
    {
        $query = IncomingLetter::query()->latest('received_date');
        $this->applyRoleScope($query, $request->user());

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('letter_number', 'like', '%' . $search . '%')
                    ->orWhere('subject', 'like', '%' . $search . '%')
                    ->orWhere('sender', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('month')) {
            $month = $request->input('month'); // Format: YYYY-MM
            $query->whereYear('received_date', substr($month, 0, 4))
                ->whereMonth('received_date', substr($month, 5, 2));
        }

        $letters = $query->paginate(10)->withQueryString();

        $statsBase = IncomingLetter::query();
        $this->applyRoleScope($statsBase, $request->user());
        $stats = [
            'total' => (clone $statsBase)->count(),
            'today' => (clone $statsBase)->whereDate('received_date', Carbon::today())->count(),
        ];

        return view('surat-masuk.index', compact('letters', 'stats'));
    }

    public function create(Request $request)
    {
        if (!$request->user()->hasAnyRole(['sekretariat', 'admin'])) {
            abort(403);
        }

        $defaultReceivedDate = Carbon::today();
        $indexYear = $defaultReceivedDate->year;
        $nextIndexNo = (IncomingLetter::query()
            ->whereYear('received_date', $indexYear)
            ->max('index_no') ?? 0) + 1;

        $defaultCategories = ['Undangan', 'Laporan', 'Permohonan'];
        $storedCategories = IncomingLetter::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->all();

        $indexNoByYear = IncomingLetter::query()
            ->selectRaw('YEAR(received_date) as year, MAX(index_no) as max_index')
            ->whereNotNull('received_date')
            ->groupBy('year')
            ->pluck('max_index', 'year')
            ->all();

        $categories = [];
        $seen = [];
        foreach (array_merge($defaultCategories, $storedCategories) as $category) {
            $key = mb_strtolower(trim($category));
            if ($key === '' || isset($seen[$key])) {
                continue;
            }
            $seen[$key] = true;
            $categories[] = $category;
        }

        $senderOptions = IncomingLetter::query()
            ->whereNotNull('sender')
            ->where('sender', '!=', '')
            ->distinct()
            ->orderBy('sender')
            ->pluck('sender')
            ->all();

        return view('tambah-surat-masuk', compact('categories', 'nextIndexNo', 'defaultReceivedDate', 'indexNoByYear', 'senderOptions'));
    }

    public function store(Request $request)
    {
        if (!$request->user()->hasAnyRole(['sekretariat', 'admin'])) {
            abort(403);
        }

        $data = $request->validate([
            'letter_number' => ['required', 'string', 'max:100'],
            'sender' => ['required', 'string', 'max:255'],
            'letter_date' => ['required', 'date'],
            'received_date' => ['required', 'date'],
            'subject' => ['required', 'string', 'max:255'],
            'index_no' => ['required', 'integer', 'min:1'],
            'category' => ['nullable', 'string', 'max:100'],
            'summary' => ['nullable', 'string'],
            'index_code' => ['nullable', 'string', 'max:100'],
            'reference_letter_date' => ['nullable', 'date'],
            'reference_letter_number' => ['nullable', 'string', 'max:100'],
            'instruction_number' => ['nullable', 'string', 'max:100'],
            'package_number' => ['nullable', 'string', 'max:100'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:20480'],
            'custom_filename' => ['nullable', 'string', 'max:255'],
        ]);

        $data['forwarded_to'] = null;
        $data['user_id'] = $request->user()->id;

        $receivedDate = Carbon::parse($data['received_date']);
        $indexYear = $receivedDate->year;
        $indexNo = (int) $data['index_no'];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFilename = $file->getClientOriginalName();
            $mimeType = $file->getMimeType();
            $fileSize = $file->getSize();

            // Handle custom filename
            $customFilename = $request->input('custom_filename');

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
            $this->storeFileLocally($file, $data, $customFilename);
        }

        // Remove custom_filename from data as it's not a database column
        unset($data['custom_filename']);

        $incomingLetter = null;
        DB::transaction(function () use (&$data, $indexNo, $indexYear, &$incomingLetter) {
            IncomingLetter::query()
                ->whereYear('received_date', $indexYear)
                ->whereNotNull('index_no')
                ->where('index_no', '>=', $indexNo)
                ->increment('index_no');

            $data['index_no'] = $indexNo;
            $incomingLetter = IncomingLetter::create($data);
        });

        if ($incomingLetter) {
            $recipients = User::query()
                ->whereIn('role', ['sekretariat', 'admin'])
                ->get();
            Notification::send($recipients, new IncomingLetterCreated($incomingLetter));
        }

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil disimpan.');
    }

    public function updateInstruction(Request $request, IncomingLetter $incomingLetter)
    {
        if (!$request->user()->hasAnyRole(['sekretariat', 'admin'])) {
            abort(403);
        }

        $data = $request->validate([
            'instruction' => ['required', 'string'],
        ]);

        $incomingLetter->fill([
            'instruction' => $data['instruction'],
        ]);
        $incomingLetter->save();

        return redirect()->route('detail-surat-masuk', $incomingLetter)
            ->with('success', 'Instruksi berhasil disimpan.');
    }

    public function updateFinalDirection(Request $request, IncomingLetter $incomingLetter)
    {
        if (!$request->user()->hasAnyRole(['admin'])) {
            abort(403);
        }

        $data = $request->validate([
            'final_direction' => ['required', 'string'],
        ]);

        $incomingLetter->fill([
            'final_direction' => $data['final_direction'],
        ]);
        $incomingLetter->save();

        return redirect()->route('detail-surat-masuk', $incomingLetter)
            ->with('success', 'Arahan final berhasil disimpan.');
    }

    public function show(IncomingLetter $incomingLetter)
    {
        $attachment = $this->buildAttachment($incomingLetter);

        return view('detail-surat-masuk', compact('incomingLetter', 'attachment'));
    }

    public function edit(Request $request, IncomingLetter $incomingLetter)
    {
        if (!$request->user()->hasAnyRole(['sekretariat', 'admin'])) {
            abort(403);
        }

        $attachment = $this->buildAttachment($incomingLetter);

        $indexNoByYear = IncomingLetter::query()
            ->selectRaw('YEAR(received_date) as year, MAX(index_no) as max_index')
            ->whereNotNull('received_date')
            ->groupBy('year')
            ->pluck('max_index', 'year')
            ->all();

        $senderOptions = IncomingLetter::query()
            ->whereNotNull('sender')
            ->where('sender', '!=', '')
            ->distinct()
            ->orderBy('sender')
            ->pluck('sender')
            ->all();

        return view('edit-surat-masuk', compact('incomingLetter', 'attachment', 'indexNoByYear', 'senderOptions'));
    }

    public function update(Request $request, IncomingLetter $incomingLetter)
    {
        if (!$request->user()->hasAnyRole(['sekretariat', 'admin'])) {
            abort(403);
        }

        $data = $request->validate([
            'letter_number' => ['required', 'string', 'max:100'],
            'sender' => ['required', 'string', 'max:255'],
            'letter_date' => ['required', 'date'],
            'received_date' => ['required', 'date'],
            'subject' => ['required', 'string', 'max:255'],
            'index_no' => ['required', 'integer', 'min:1'],
            'category' => ['nullable', 'string', 'max:100'],
            'summary' => ['nullable', 'string'],
            'index_code' => ['nullable', 'string', 'max:100'],
            'reference_letter_date' => ['nullable', 'date'],
            'reference_letter_number' => ['nullable', 'string', 'max:100'],
            'instruction_number' => ['nullable', 'string', 'max:100'],
            'package_number' => ['nullable', 'string', 'max:100'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:20480'],
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Hapus file lama jika ada
            if ($incomingLetter->file_path) {
                $oldDisk = Storage::disk($incomingLetter->storage_disk ?? $this->lettersDiskName());
                if ($oldDisk->exists($incomingLetter->file_path)) {
                    $oldDisk->delete($incomingLetter->file_path);
                }
            }

            // Simpan file baru ke local storage
            $this->storeFileLocally($file, $data);
        }

        $oldIndexNo = $incomingLetter->index_no;
        $oldYear = $incomingLetter->received_date
            ? Carbon::parse($incomingLetter->received_date)->year
            : null;

        $newReceivedDate = Carbon::parse($data['received_date']);
        $newYear = $newReceivedDate->year;
        $newIndexNo = (int) $data['index_no'];

        DB::transaction(function () use ($incomingLetter, $data, $oldIndexNo, $oldYear, $newIndexNo, $newYear) {
            if ($oldIndexNo && $oldYear !== null && ($oldYear !== $newYear || $oldIndexNo !== $newIndexNo)) {
                IncomingLetter::query()
                    ->whereYear('received_date', $oldYear)
                    ->whereNotNull('index_no')
                    ->where('index_no', '>', $oldIndexNo)
                    ->decrement('index_no');
            }

            if ($oldYear !== $newYear || $oldIndexNo !== $newIndexNo) {
                IncomingLetter::query()
                    ->whereYear('received_date', $newYear)
                    ->whereNotNull('index_no')
                    ->where('index_no', '>=', $newIndexNo)
                    ->where('id', '!=', $incomingLetter->id)
                    ->increment('index_no');
            }

            $data['index_no'] = $newIndexNo;
            $incomingLetter->update($data);
        });

        return redirect()->route('detail-surat-masuk', $incomingLetter)
            ->with('success', 'Surat masuk berhasil diperbarui.');
    }

    public function download(IncomingLetter $incomingLetter)
    {
        // Jika file disimpan di Google Drive
        if ($incomingLetter->gdrive_file_id) {
            $downloadUrl = $this->googleDrive->getDownloadUrl($incomingLetter->gdrive_file_id);
            return redirect()->away($downloadUrl);
        }

        // Fallback ke local storage
        $diskName = $incomingLetter->storage_disk ?? $this->lettersDiskName();
        $disk = Storage::disk($diskName);

        if (!$incomingLetter->file_path || !$disk->exists($incomingLetter->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return $this->streamDownload($disk, $incomingLetter->file_path);
    }

    public function preview(IncomingLetter $incomingLetter)
    {
        // Jika file disimpan di Google Drive
        if ($incomingLetter->gdrive_file_id) {
            $previewUrl = $this->googleDrive->getPreviewUrl($incomingLetter->gdrive_file_id);
            return redirect()->away($previewUrl);
        }

        // Fallback ke local storage
        $diskName = $incomingLetter->storage_disk ?? $this->lettersDiskName();
        $disk = Storage::disk($diskName);

        if (!$incomingLetter->file_path || !$disk->exists($incomingLetter->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $mimeType = $incomingLetter->file_mime ?? 'application/octet-stream';
        $stream = $disk->readStream($incomingLetter->file_path);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . ($incomingLetter->original_filename ?? basename($incomingLetter->file_path)) . '"',
        ]);
    }

    private function buildAttachment(IncomingLetter $letter): ?array
    {
        // Jika file di Google Drive
        if ($letter->gdrive_file_id) {
            return [
                'name' => $letter->gdrive_file_name ?? $letter->original_filename ?? 'File',
                'size' => $this->formatBytes($letter->file_size ?? 0),
                'url' => route('surat-masuk.download', $letter),
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
            'url' => route('surat-masuk.download', $letter),
            'preview_url' => route('surat-masuk.preview', $letter),
            'is_gdrive' => false,
            'mime_type' => $letter->file_mime,
        ];
    }

    private function storeFileLocally($file, array &$data, ?string $customFilename = null): void
    {
        $disk = $this->lettersDiskName();
        $originalFilename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        // Use custom filename if provided, otherwise use original
        if ($customFilename && trim($customFilename) !== '') {
            $filename = preg_replace('/[^a-zA-Z0-9_\-\s]/', '', trim($customFilename));
            $filename = str_replace(' ', '_', $filename);
            $filename = $filename . '.' . $extension;
        } else {
            $filename = $originalFilename;
        }

        // Ensure unique filename
        $path = 'incoming_letters/' . time() . '_' . $filename;
        $file->storeAs('incoming_letters', time() . '_' . $filename, $disk);

        $data['file_path'] = $path;
        $data['storage_disk'] = $disk;
        $data['original_filename'] = $customFilename && trim($customFilename) !== ''
            ? trim($customFilename) . '.' . $extension
            : $originalFilename;
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

    private function applyRoleScope(Builder $query, ?User $user): void
    {
        if (!$user || $user->hasRole('admin')) {
            return;
        }

        // Sekretariat hanya melihat surat dari user dengan role sekretariat atau admin
        if ($user->hasRole('sekretariat')) {
            $query->whereHas('user', function (Builder $query) {
                $query->whereIn('role', ['sekretariat', 'admin']);
            });
        }
    }

    public function destroy(Request $request, IncomingLetter $incomingLetter)
    {
        if (!$request->user()->hasAnyRole(['sekretariat', 'admin'])) {
            abort(403);
        }

        // Hapus file lampiran jika ada
        if ($incomingLetter->file_path) {
            $disk = $this->lettersDisk();
            if ($disk->exists($incomingLetter->file_path)) {
                $disk->delete($incomingLetter->file_path);
            }
        }

        // Hapus dari Google Drive jika ada
        if ($incomingLetter->gdrive_file_id && $this->googleDrive->isConfigured()) {
            try {
                $this->googleDrive->deleteFile($incomingLetter->gdrive_file_id);
            } catch (\Exception $e) {
                // Log error tapi jangan gagalkan proses hapus
                \Log::warning('Gagal hapus file dari Google Drive: ' . $e->getMessage());
            }
        }

        $incomingLetter->delete();

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil dihapus.');
    }
}
