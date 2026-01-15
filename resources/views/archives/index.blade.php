@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Arsip Surat</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('archives.create') }}" class="btn btn-primary">Buat Arsip Baru</a>
        <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-file-earmark-bar-graph me-1"></i> Buat Laporan
        </a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor</th>
                <th>Tanggal</th>
                <th>Perihal</th>
                <th>Pengirim</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($archives as $archive)
            <tr>
                <td>{{ $loop->iteration + ($archives->currentPage()-1)*$archives->perPage() }}</td>
                <td>{{ $archive->nomor_surat }}</td>
                <td>{{ optional($archive->tanggal_surat)->format('Y-m-d') }}</td>
                <td>{{ $archive->perihal }}</td>
                <td>{{ $archive->pengirim }}</td>
                <td>
                    <a href="{{ route('archives.show', $archive) }}" class="btn btn-sm btn-info">Lihat</a>
                    <a href="{{ route('archives.edit', $archive) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('archives.destroy', $archive) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus arsip ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">Belum ada arsip.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $archives->links() }}
</div>
@endsection