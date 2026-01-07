<?php

namespace App\Http\Controllers;

use App\Models\OutgoingLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OutgoingLetterController extends Controller
{
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

        if ($request->filled('date')) {
            $query->whereDate('letter_date', $request->input('date'));
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
            $data['file_path'] = $request->file('file')->store('outgoing_letters', 'public');
        }

        OutgoingLetter::create($data);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil disimpan.');
    }

    public function show(OutgoingLetter $outgoingLetter)
    {
        $attachment = $this->buildAttachment($outgoingLetter->file_path);

        return view('detail-surat-keluar', compact('outgoingLetter', 'attachment'));
    }

    public function download(OutgoingLetter $outgoingLetter)
    {
        if (!$outgoingLetter->file_path || !Storage::disk('public')->exists($outgoingLetter->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($outgoingLetter->file_path);
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
