
<x-app-layout>
  @php
    $status = $incomingLetter->status ?? 'Baru';
    $statusClass = match ($status) {
      'Baru' => 'badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle',
      'Menunggu' => 'badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle',
      'Diproses' => 'badge rounded-pill bg-orange-100 text-orange-700 border border-orange-200',
      'Selesai' => 'badge rounded-pill bg-success-subtle text-success border border-success-subtle',
      default => 'badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle',
    };
    $canInputInstruction = auth()->user()->hasAnyRole(['sekretaris', 'admin']);
    $canInputFinal = auth()->user()->hasAnyRole(['kepala_badan', 'admin']);
    $forwardedLabel = \App\Models\User::roleLabelFor($incomingLetter->forwarded_to);
  @endphp
  <div class="bg-[#f5f7fb]">
    <main class="container py-4">
    <a href="{{ route('surat-masuk.index') }}" class="text-muted text-decoration-none fw-semibold d-inline-flex align-items-center gap-2 hover:text-gray-800">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <h1 class="mt-2 mb-1 text-3xl font-extrabold text-gray-900">{{ $incomingLetter->subject }}</h1>
    <p class="text-gray-500 mb-4">Informasi lengkap mengenai surat masuk ({{ $incomingLetter->letter_number }})</p>

    <section class="card border-0 shadow-sm mt-3">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-3">
          <div class="d-flex gap-2 flex-wrap">
            <span class="{{ $statusClass }}">{{ $status }}</span>
            @if ($incomingLetter->category)
              <span class="badge rounded-pill bg-orange-100 text-orange-700 border border-orange-200">{{ $incomingLetter->category }}</span>
            @endif
          </div>
          <button class="btn btn-light btn-sm border" aria-label="menu"><i class="bi bi-three-dots-vertical"></i></button>
        </div>

        <div class="row g-4">
          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Nomor Surat</div>
            <div class="fw-bold text-gray-900">{{ $incomingLetter->letter_number }}</div>
          </div>
          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Pengirim</div>
            <div class="fw-bold text-gray-900">{{ $incomingLetter->sender }}</div>
          </div>

          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Tanggal Surat</div>
            <div class="fw-bold text-gray-900">{{ optional($incomingLetter->letter_date)->format('d M Y') }}</div>
          </div>
          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Perihal</div>
            <div class="fw-bold text-gray-900">{{ $incomingLetter->subject }}</div>
          </div>

          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Tanggal Diterima</div>
            <div class="fw-bold text-gray-900">{{ optional($incomingLetter->received_date)->format('d M Y') }}</div>
          </div>
          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Kategori</div>
            <div class="fw-bold text-gray-900">{{ $incomingLetter->category ?? '-' }}</div>
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
          {{ $incomingLetter->summary ?? 'Ringkasan surat belum tersedia.' }}
        </p>
      </div>
    </section>

    <section class="card border-0 shadow-sm mt-3">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 fw-bold text-gray-900 mb-3">
          <span class="d-inline-flex align-items-center justify-content-center rounded-2 bg-orange-100 text-orange-600 border border-orange-200 w-7 h-7 text-sm">
            <i class="bi bi-journal-check"></i>
          </span>
          Disposisi & Arahan
        </div>
        <div class="row g-4">
          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Instruksi Sekretaris</div>
            <div class="fw-bold text-gray-900">{!! nl2br(e($incomingLetter->instruction ?? '-')) !!}</div>
          </div>
          <div class="col-lg-6">
            <div class="text-muted small fw-bold">Diteruskan Kepada</div>
            <div class="fw-bold text-gray-900">{{ $incomingLetter->forwarded_to ? $forwardedLabel : '-' }}</div>
          </div>
          <div class="col-12">
            <div class="text-muted small fw-bold">Arahan Kepala Badan</div>
            <div class="fw-bold text-gray-900">{!! nl2br(e($incomingLetter->final_direction ?? '-')) !!}</div>
          </div>
        </div>
      </div>
    </section>

    @if ($canInputInstruction)
      <section class="card border-0 shadow-sm mt-3">
        <div class="card-body">
          <div class="d-flex align-items-center gap-2 fw-bold text-gray-900 mb-3">
            <span class="d-inline-flex align-items-center justify-content-center rounded-2 bg-orange-100 text-orange-600 border border-orange-200 w-7 h-7 text-sm">
              <i class="bi bi-pencil-square"></i>
            </span>
            Instruksi Sekretaris
          </div>
          <form method="POST" action="{{ route('surat-masuk.instruction', $incomingLetter) }}">
            @csrf
            @method('PATCH')
            <div class="mb-3">
              <label class="text-muted small fw-bold mb-2 d-block">Instruksi</label>
              <textarea class="form-control" name="instruction" rows="4" placeholder="Tuliskan instruksi untuk disposisi..." required>{{ old('instruction', $incomingLetter->instruction) }}</textarea>
              @error('instruction')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div class="d-flex justify-content-end">
              <button class="btn text-white bg-[#ff7f00] hover:bg-[#f36f00] border-0 fw-bold" type="submit">
                <i class="bi bi-send me-2"></i> Teruskan ke Kepala Badan
              </button>
            </div>
          </form>
        </div>
      </section>
    @endif

    @if ($canInputFinal)
      <section class="card border-0 shadow-sm mt-3">
        <div class="card-body">
          <div class="d-flex align-items-center gap-2 fw-bold text-gray-900 mb-3">
            <span class="d-inline-flex align-items-center justify-content-center rounded-2 bg-orange-100 text-orange-600 border border-orange-200 w-7 h-7 text-sm">
              <i class="bi bi-check2-square"></i>
            </span>
            Arahan Kepala Badan
          </div>
          @if ($incomingLetter->forwarded_to !== 'kepala_badan' && !auth()->user()->hasRole('admin'))
            <div class="text-muted small">Menunggu instruksi dari sekretaris sebelum memberikan arahan final.</div>
          @else
            <form method="POST" action="{{ route('surat-masuk.final-direction', $incomingLetter) }}">
              @csrf
              @method('PATCH')
              <div class="mb-3">
                <label class="text-muted small fw-bold mb-2 d-block">Arahan Final</label>
                <textarea class="form-control" name="final_direction" rows="4" placeholder="Tuliskan arahan final..." required>{{ old('final_direction', $incomingLetter->final_direction) }}</textarea>
                @error('final_direction')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>
              <div class="d-flex justify-content-end">
                <button class="btn text-white bg-[#2f855a] hover:bg-[#276749] border-0 fw-bold" type="submit">
                  <i class="bi bi-check-circle me-2"></i> Tandai Selesai
                </button>
              </div>
            </form>
          @endif
        </div>
      </section>
    @endif

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
              <a class="btn btn-sm text-white bg-[#ff7f00] hover:bg-[#f36f00] border-0 fw-bold" href="{{ route('surat-masuk.download', $incomingLetter) }}">Unduh</a>
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
