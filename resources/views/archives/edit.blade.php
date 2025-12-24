@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Arsip Surat</h1>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('archives.update', $archive) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nomor Surat</label>
            <input type="text" name="nomor_surat" class="form-control" value="{{ old('nomor_surat', $archive->nomor_surat) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Surat</label>
            <input type="date" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat', optional($archive->tanggal_surat)->format('Y-m-d')) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis</label>
            <select name="jenis" class="form-control">
                <option value="">-- Pilih --</option>
                <option value="masuk" {{ old('jenis', $archive->jenis) == 'masuk' ? 'selected' : '' }}>Masuk</option>
                <option value="keluar" {{ old('jenis', $archive->jenis) == 'keluar' ? 'selected' : '' }}>Keluar</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Pengirim</label>
            <input type="text" name="pengirim" class="form-control" value="{{ old('pengirim', $archive->pengirim) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Penerima</label>
            <input type="text" name="penerima" class="form-control" value="{{ old('penerima', $archive->penerima) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Perihal</label>
            <input type="text" name="perihal" class="form-control" value="{{ old('perihal', $archive->perihal) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Ringkasan</label>
            <textarea name="ringkasan" class="form-control">{{ old('ringkasan', $archive->ringkasan) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Lampiran (pdf/jpg/png/doc)</label>
            @if($archive->file_path)
            <div>File: <a href="{{ asset('storage/' . $archive->file_path) }}" target="_blank">{{ basename($archive->file_path) }}</a></div>
            @endif
            <input type="file" name="lampiran" class="form-control">
        </div>
        <button class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection