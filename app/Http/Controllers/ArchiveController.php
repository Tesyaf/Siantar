<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ArchiveController extends Controller
{
    /**
     * Menampilkan daftar arsip dengan filter dan pagination.
     */
    public function index(Request $request)
    {
        $archives = Archive::latest('tanggal_surat') // Urutkan berdasarkan tanggal surat, bukan created_at
            ->filter($request->only(['search', 'jenis', 'folder']))
            ->paginate(15)
            ->withQueryString();

        return view('archives.index', compact('archives'));
    }

    public function create()
    {
        return view('archives.create');
    }

    /**
     * Menyimpan arsip baru ke database dan storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_surat'   => ['required', 'string', 'unique:archives,nomor_surat', 'max:100'],
            'tanggal_surat' => ['required', 'date'],
            'jenis'         => ['required', 'string', 'in:Surat Masuk,Surat Keluar,Dokumen Lain'], // Standarisasi input
            'pengirim'      => ['nullable', 'string', 'max:255'],
            'penerima'      => ['nullable', 'string', 'max:255'],
            'perihal'       => ['required', 'string', 'max:255'],
            'ringkasan'     => ['nullable', 'string'],
            'folder'        => ['nullable', 'string', 'max:50'],
            'tags'          => ['nullable', 'string', 'max:255'],
            'status'        => ['nullable', 'string', 'in:aktif,arsip'],
            'lampiran'      => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx', 'max:20480'], // Max 20MB
        ]);

        $data['status'] = $data['status'] ?? 'aktif';

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $disk = $this->lettersDiskName();
            
            // Simpan File Fisik
            $path = $file->store('archives', $disk);
            
            // Simpan Metadata Lengkap
            $data['file_path'] = $path;
            $data['storage_disk'] = $disk;
            $data['original_filename'] = $file->getClientOriginalName();
            $data['file_mime'] = $file->getMimeType();
            $data['file_size'] = $file->getSize();
        }

        Archive::create($data);

        return redirect()->route('archives.index')->with('success', 'Arsip surat berhasil disimpan.');
    }

    public function show(Archive $archive)
    {
        return view('archives.show', compact('archive'));
    }

    public function edit(Archive $archive)
    {
        return view('archives.edit', compact('archive'));
    }

    /**
     * Memperbarui data arsip.
     */
    public function update(Request $request, Archive $archive)
    {
        $data = $request->validate([
            'nomor_surat'   => ['required', 'string', Rule::unique('archives')->ignore($archive->id), 'max:100'],
            'tanggal_surat' => ['required', 'date'],
            'jenis'         => ['required', 'string', 'in:Surat Masuk,Surat Keluar,Dokumen Lain'],
            'pengirim'      => ['nullable', 'string', 'max:255'],
            'penerima'      => ['nullable', 'string', 'max:255'],
            'perihal'       => ['required', 'string', 'max:255'],
            'ringkasan'     => ['nullable', 'string'],
            'folder'        => ['nullable', 'string', 'max:50'],
            'tags'          => ['nullable', 'string', 'max:255'],
            'status'        => ['nullable', 'string', 'in:aktif,arsip'],
            'lampiran'      => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx', 'max:20480'],
        ]);

        if ($request->hasFile('lampiran')) {
            // Hapus file lama fisik (Manual check perlu di update karena replace file tidak trigger delete model)
            if ($archive->hasFile()) {
                Storage::disk($archive->storage_disk ?? 'public')->delete($archive->file_path);
            }

            $file = $request->file('lampiran');
            $disk = $this->lettersDiskName();
            $path = $file->store('archives', $disk);

            $data['file_path'] = $path;
            $data['storage_disk'] = $disk;
            $data['original_filename'] = $file->getClientOriginalName();
            $data['file_mime'] = $file->getMimeType();
            $data['file_size'] = $file->getSize();
        }

        $archive->update($data);

        return redirect()->route('archives.index')->with('success', 'Data arsip berhasil diperbarui.');
    }

    /**
     * Menghapus arsip (Soft Delete).
     * File fisik TIDAK dihapus disini, tapi nanti saat Force Delete.
     * Ini fitur keamanan agar jika salah hapus, file masih bisa dikembalikan.
     */
    public function destroy(Archive $archive)
    {
        $archive->delete();
        return redirect()->route('archives.index')->with('success', 'Arsip berhasil dipindahkan ke sampah.');
    }

    /**
     * Mendownload file lampiran.
     */
    public function download(Archive $archive)
    {
        if (!$archive->hasFile()) {
            return back()->with('error', 'File fisik tidak ditemukan.');
        }

        return Storage::disk($archive->storage_disk ?? 'public')->download(
            $archive->file_path, 
            $archive->original_filename
        );
    }

    /**
     * Melihat file lampiran di browser (Preview).
     * Cocok untuk PDF atau Gambar.
     */
    public function preview(Archive $archive)
    {
        if (!$archive->hasFile()) {
            return back()->with('error', 'File fisik tidak ditemukan.');
        }

        return Storage::disk($archive->storage_disk ?? 'public')->response($archive->file_path);
    }

    private function lettersDiskName(): string
    {
        return config('filesystems.letters_disk', 'public');
    }
}
