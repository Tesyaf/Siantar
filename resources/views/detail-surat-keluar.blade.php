
<x-app-layout>
  @php
    $status = $outgoingLetter->status ?? 'Menunggu';
    $statusClass = match ($status) {
      'Menunggu' => 'badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle',
      'Diproses' => 'badge rounded-pill bg-orange-100 text-orange-700 border border-orange-200',
      'Terkirim' => 'badge rounded-pill bg-success-subtle text-success border border-success-subtle',
      'Selesai' => 'badge rounded-pill bg-success-subtle text-success border border-success-subtle',
      default => 'badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle',
    };
  @endphp
  <div class="bg-[#f5f7fb]">
    <main class="container py-4">
    <a href="{{ route('surat-keluar.index') }}" class="text-muted text-decoration-none fw-semibold d-inline-flex align-items-center gap-2 hover:text-gray-800">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <h1 class="mt-2 mb-1 text-3xl font-extrabold text-gray-900">{{ $outgoingLetter->subject }}</h1>
    <p class="text-gray-500 mb-4">Informasi lengkap mengenai surat keluar ({{ $outgoingLetter->letter_number }})</p>

    <section class="card border-0 shadow-sm mt-3">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-3">
          <div class="d-flex flex-column gap-2">
            <span class="{{ $statusClass }}">{{ $status }}</span>
            @if ($outgoingLetter->category)
              <span class="badge rounded-pill bg-orange-100 text-orange-700 border border-orange-200">{{ $outgoingLetter->category }}</span>
            @endif
          </div>
          <button class="btn btn-light btn-sm border" aria-label="menu"><i class="bi bi-three-dots-vertical"></i></button>
        </div>

        <div class="row g-4">
          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Nomor Surat</div>
            <div class="fw-bold text-gray-900">{{ $outgoingLetter->letter_number }}</div>
          </div>
          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Tujuan</div>
            <div class="fw-bold text-gray-900">{{ $outgoingLetter->recipient }}</div>
          </div>

          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Tanggal Surat</div>
            <div class="fw-bold text-gray-900">{{ optional($outgoingLetter->letter_date)->format('d M Y') }}</div>
          </div>
          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Perihal</div>
            <div class="fw-bold text-gray-900">{{ $outgoingLetter->subject }}</div>
          </div>

          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Jenis Surat</div>
            <div class="fw-bold text-gray-900">Surat Keluar</div>
          </div>
          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Kategori</div>
            <div class="fw-bold text-gray-900">{{ $outgoingLetter->category ?? '-' }}</div>
          </div>
        </div>
      </div>
    </section>

    <section class="card border-0 shadow-sm mt-3">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 fw-bold text-gray-900 mb-3">
          <span class="d-inline-flex align-items-center justify-content-center rounded-2 bg-orange-100 text-orange-600 border border-orange-200 w-7 h-7 text-sm">
            <i class="bi bi-file-earmark-text"></i>
          </span>
          Ringkasan Isi Surat
        </div>
        <p class="text-gray-700 small mb-0">
          {{ $outgoingLetter->summary ?? 'Ringkasan surat belum tersedia.' }}
        </p>
      </div>
    </section>

    <section class="card border-0 shadow-sm mt-3">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 fw-bold text-gray-900 mb-3">
          <span class="d-inline-flex align-items-center justify-content-center rounded-2 bg-orange-100 text-orange-600 border border-orange-200 w-7 h-7 text-sm">
            <i class="bi bi-paperclip"></i>
          </span>
          Lampiran Dokumen
        </div>
        @if ($attachment)
          @php
            $extension = strtolower(pathinfo($attachment['name'], PATHINFO_EXTENSION));
            $fileBadge = $extension === 'pdf' ? 'PDF' : strtoupper(substr($extension, 0, 1));
            $fileBadgeClass = match (true) {
              in_array($extension, ['doc', 'docx'], true) => 'bg-blue-100 text-blue-700 border border-blue-200',
              $extension === 'pdf' => 'bg-red-100 text-red-700 border border-red-200',
              default => 'bg-gray-100 text-gray-700 border border-gray-200',
            };
          @endphp
          <div class="d-flex align-items-center gap-3 border border-gray-200 rounded-3 p-3">
            <div class="d-inline-flex align-items-center justify-content-center rounded-2 px-2 py-1 fw-bold small {{ $fileBadgeClass }}">{{ $fileBadge }}</div>
            <div>
              <div class="fw-bold text-gray-900">{{ $attachment['name'] }}</div>
              <div class="text-muted small">{{ strtoupper($extension) }} - {{ $attachment['size'] }}</div>
            </div>
            <div class="ms-auto d-flex gap-2">
              <a class="btn btn-sm border border-[#ff7f00] text-[#ff7f00] hover:bg-orange-50 fw-bold" href="{{ $attachment['url'] }}" target="_blank" rel="noopener">Lihat</a>
              <a class="btn btn-sm text-white bg-[#ff7f00] hover:bg-[#f36f00] border-0 fw-bold" href="{{ route('surat-keluar.download', $outgoingLetter) }}">Unduh</a>
            </div>
          </div>
        @else
          <div class="text-muted">Tidak ada lampiran untuk surat ini.</div>
        @endif
      </div>
    </section>
    </main>
  </div>
</x-app-layout>
