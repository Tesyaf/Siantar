
<x-app-layout>
  @php
    $statusClasses = [
      'Baru' => 'badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle',
      'Menunggu' => 'badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle',
      'Diproses' => 'badge rounded-pill bg-orange-100 text-orange-700 border border-orange-200',
      'Selesai' => 'badge rounded-pill bg-success-subtle text-success border border-success-subtle',
    ];
  @endphp

  <main class="container py-4">

    <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none fw-semibold d-inline-flex align-items-center gap-2 hover:text-gray-800">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <h1 class="mt-2 mb-1 text-3xl font-extrabold text-gray-900">Surat Masuk</h1>
    <p class="text-gray-500 mb-4">Daftar seluruh surat masuk yang Anda terima</p>

    <div class="row g-3 align-items-stretch">
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center justify-content-between">
            <div>
              <div class="text-muted small fw-bold">Total Surat Masuk</div>
              <div class="fs-3 fw-bold text-gray-900">{{ $stats['total'] }}</div>
            </div>
            <div class="text-orange-500 fs-4"><i class="bi bi-send-fill"></i></div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center justify-content-between">
            <div>
              <div class="text-muted small fw-bold">Belum Diproses</div>
              <div class="fs-3 fw-bold text-gray-900">{{ $stats['pending'] }}</div>
            </div>
            <div class="text-warning fs-4"><i class="bi bi-clock-fill"></i></div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center justify-content-between">
            <div>
              <div class="text-muted small fw-bold">Sudah Diproses</div>
              <div class="fs-3 fw-bold text-gray-900">{{ $stats['processed'] }}</div>
            </div>
            <div class="text-success fs-4"><i class="bi bi-check-circle-fill"></i></div>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
      <button class="btn text-white bg-[#ff7f00] hover:bg-[#f36f00] border-0 fw-bold">
        <i class="bi bi-list-task me-2"></i> Lihat Laporan Bulanan
      </button>
    </div>

    <form class="card border-0 shadow-sm mt-4" method="GET" action="{{ route('surat-masuk.index') }}">
      <div class="card-body">
        <div class="row g-3">
          <div class="col-lg-6">
            <div class="fw-bold text-gray-700 small mb-2">Pencarian</div>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input class="form-control" type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor surat atau perihal..." />
            </div>
          </div>
          <div class="col-lg-3">
            <div class="fw-bold text-gray-700 small mb-2">Status</div>
            <select class="form-select" name="status">
              <option value="">Semua Status</option>
              @foreach ($statusOptions as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-lg-3">
            <div class="fw-bold text-gray-700 small mb-2">Tanggal</div>
            <div class="input-group">
              <input class="form-control" type="date" name="date" value="{{ request('date') }}" />
              <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-end">
            <button class="btn text-white bg-[#ff7f00] hover:bg-[#f36f00] border-0 fw-bold" type="submit">
              <i class="bi bi-filter me-2"></i>Terapkan Filter
            </button>
          </div>
        </div>
      </div>
    </form>

    <section class="card border-0 shadow-sm mt-4">
      <div class="card-body p-0 p-lg-3">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="min-w-[140px]">Nomor Surat</th>
                <th class="min-w-[120px]">Tanggal</th>
                <th class="min-w-[160px]">Pengirim</th>
                <th>Perihal</th>
                <th class="min-w-[120px] text-center">Status</th>
                <th class="min-w-[130px] text-center">Aksi</th>
              </tr>
            </thead>
          <tbody>
            @forelse ($letters as $letter)
              @php
                $status = $letter->status ?? 'Baru';
              @endphp
              <tr>
                <td class="fw-bold">{{ $letter->letter_number }}</td>
                <td class="text-muted">{{ optional($letter->received_date)->format('d M Y') }}</td>
                <td class="text-muted">{{ $letter->sender }}</td>
                <td class="text-muted">{{ $letter->subject }}</td>
                <td class="text-center"><span class="{{ $statusClasses[$status] ?? $statusClasses['Baru'] }}">{{ $status }}</span></td>
                <td class="text-center">
                  <a class="btn btn-sm fw-bold !text-white !bg-orange-500 hover:!bg-orange-600 !border-0" href="{{ route('detail-surat-masuk', $letter) }}">Lihat Detail</a>
                </td>
              </tr>
            @empty
              <tr>
                <td class="text-center text-muted" colspan="6">Belum ada surat masuk.</td>
              </tr>
            @endforelse
          </tbody>
          </table>
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-3 px-3 pb-3">
        <div class="text-muted small">
          @if ($letters->total() > 0)
            Menampilkan {{ $letters->firstItem() }}-{{ $letters->lastItem() }} dari {{ $letters->total() }} surat masuk
          @else
            Belum ada surat masuk
          @endif
        </div>
        <nav>
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item {{ $letters->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link" href="{{ $letters->previousPageUrl() ?? '#' }}" aria-label="Prev">
                <i class="bi bi-chevron-left"></i>
              </a>
            </li>
            <li class="page-item active"><span class="page-link">{{ $letters->currentPage() }}</span></li>
            <li class="page-item {{ $letters->hasMorePages() ? '' : 'disabled' }}">
              <a class="page-link" href="{{ $letters->nextPageUrl() ?? '#' }}" aria-label="Next">
                <i class="bi bi-chevron-right"></i>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </section>

  </main>
</x-app-layout>


