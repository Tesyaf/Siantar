@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Arsip</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $archive->perihal }}</h5>
            <p><strong>Nomor:</strong> {{ $archive->nomor_surat }}</p>
            <p><strong>Tanggal:</strong> {{ optional($archive->tanggal_surat)->format('Y-m-d') }}</p>
            <p><strong>Pengirim:</strong> {{ $archive->pengirim }}</p>
            <p><strong>Penerima:</strong> {{ $archive->penerima }}</p>
            <p><strong>Ringkasan:</strong><br>{{ $archive->ringkasan }}</p>
            @if($archive->file_path)
            <p><strong>Lampiran:</strong> <a href="{{ asset('storage/' . $archive->file_path) }}" target="_blank">Download</a></p>
            @endif
        </div>
    </div>

    <a href="{{ route('archives.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection