<?php

namespace App\Http\Controllers;

use App\Models\IncomingLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncomingLetterController extends Controller
{
    public function index(Request $request)
    {
        $query = IncomingLetter::query()->latest('received_date');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('letter_number', 'like', '%' . $search . '%')
                    ->orWhere('subject', 'like', '%' . $search . '%')
                    ->orWhere('sender', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('date')) {
            $query->whereDate('received_date', $request->input('date'));
        }

        $letters = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => IncomingLetter::count(),
            'pending' => IncomingLetter::whereIn('status', ['Baru', 'Menunggu'])->count(),
            'processed' => IncomingLetter::whereIn('status', ['Diproses', 'Selesai'])->count(),
        ];

        $statusOptions = ['Baru', 'Menunggu', 'Diproses', 'Selesai'];

        return view('surat-masuk.index', compact('letters', 'stats', 'statusOptions'));
    }

    public function create(Request $request)
    {
        if (!$request->user()->hasAnyRole(['sekretariat', 'admin'])) {
            abort(403);
        }

        return view('tambah-surat-masuk');
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
            'category' => ['nullable', 'string', 'max:100'],
            'summary' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:Baru,Menunggu,Diproses,Selesai'],
            'index_code' => ['nullable', 'string', 'max:100'],
            'reference_letter_date' => ['nullable', 'date'],
            'reference_letter_number' => ['nullable', 'string', 'max:100'],
            'instruction_number' => ['nullable', 'string', 'max:100'],
            'package_number' => ['nullable', 'string', 'max:100'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:20480'],
        ]);

        $data['status'] = $data['status'] ?? 'Baru';
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('incoming_letters', 'public');
        }

        IncomingLetter::create($data);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil disimpan.');
    }

    public function updateInstruction(Request $request, IncomingLetter $incomingLetter)
    {
        if (!$request->user()->hasAnyRole(['sekretaris', 'admin'])) {
            abort(403);
        }

        $data = $request->validate([
            'instruction' => ['required', 'string'],
        ]);

        $incomingLetter->fill([
            'instruction' => $data['instruction'],
            'forwarded_to' => 'kepala_badan',
            'status' => 'Diproses',
        ]);
        $incomingLetter->save();

        return redirect()->route('detail-surat-masuk', $incomingLetter)
            ->with('success', 'Instruksi sekretaris berhasil disimpan.');
    }

    public function updateFinalDirection(Request $request, IncomingLetter $incomingLetter)
    {
        if (!$request->user()->hasAnyRole(['kepala_badan', 'admin'])) {
            abort(403);
        }

        if ($request->user()->hasRole('kepala_badan') && $incomingLetter->forwarded_to !== 'kepala_badan') {
            abort(403);
        }

        $data = $request->validate([
            'final_direction' => ['required', 'string'],
        ]);

        $incomingLetter->fill([
            'final_direction' => $data['final_direction'],
            'status' => 'Selesai',
        ]);
        $incomingLetter->save();

        return redirect()->route('detail-surat-masuk', $incomingLetter)
            ->with('success', 'Arahan kepala badan berhasil disimpan.');
    }

    public function show(IncomingLetter $incomingLetter)
    {
        $attachment = $this->buildAttachment($incomingLetter->file_path);

        return view('detail-surat-masuk', compact('incomingLetter', 'attachment'));
    }

    public function download(IncomingLetter $incomingLetter)
    {
        if (!$incomingLetter->file_path || !Storage::disk('public')->exists($incomingLetter->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($incomingLetter->file_path);
    }

    private function buildAttachment(?string $path): ?array
    {
        if (!$path || !Storage::disk('public')->exists($path)) {
            return null;
        }

        $size = Storage::disk('public')->size($path);

        return [
            'name' => basename($path),
            'size' => $this->formatBytes($size),
            'url' => Storage::disk('public')->url($path),
        ];
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
}
