<x-app-layout>
  @php
    $canInputLetter = Auth::user()->hasAnyRole(['sekretariat', 'admin']);
    $jenisClasses = [
      'Surat Masuk' => 'badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle',
      'Surat Keluar' => 'badge rounded-pill bg-success-subtle text-success border border-success-subtle',
    ];
    $statusClasses = [
      'aktif' => 'badge rounded-pill bg-success-subtle text-success border border-success-subtle',
      'arsip' => 'badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle',
      'baru' => 'badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle',
      'menunggu' => 'badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle',
      'diproses' => 'badge rounded-pill bg-orange-100 text-orange-700 border border-orange-200',
      'terkirim' => 'badge rounded-pill bg-success-subtle text-success border border-success-subtle',
      'selesai' => 'badge rounded-pill bg-success-subtle text-success border border-success-subtle',
    ];
  @endphp
  <main class="container py-4">
    <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none fw-semibold d-inline-flex align-items-center gap-2 hover:text-gray-800">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <div class="text-center mt-2">
      <div class="text-3xl font-extrabold text-gray-900">Arsip Digital</div>
      <p class="text-gray-500 mb-0">Telusuri arsip surat masuk dan surat keluar dengan mudah</p>
    </div>

    <form method="GET" action="{{ route('cari-arsip') }}">
      <section class="card border-0 shadow-sm mt-4">
        <div class="card-body">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nomor surat, perihal, atau instansi..." />
          </div>
          <div class="d-flex justify-content-center mt-3">
            <button class="btn text-white bg-[#ff7f00] hover:bg-[#f36f00] border-0 fw-bold" type="submit">
              <i class="bi bi-search me-2"></i> Cari Arsip Digital
            </button>
          </div>
        </div>
      </section>

      <section class="card border-0 shadow-sm mt-3">
        <div class="card-body">
          <div class="fw-bold text-gray-900 mb-3">Filter Lanjutan</div>
          <div class="row g-3 align-items-end">
            <div class="col-lg-3">
              <div class="fw-bold text-gray-700 small mb-2">Jenis Surat</div>
              <select class="form-select" name="jenis">
                <option value="">Semua</option>
                @foreach ($jenisOptions as $jenis)
                  <option value="{{ $jenis }}" @selected(request('jenis') === $jenis)>{{ $jenis }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-lg-3">
              <div class="fw-bold text-gray-700 small mb-2">Kategori Surat</div>
              <select class="form-select" name="folder">
                <option value="">Semua Kategori</option>
                @foreach ($folderOptions as $folder)
                  <option value="{{ $folder }}" @selected(request('folder') === $folder)>{{ $folder }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-lg-3">
              <div class="fw-bold text-gray-700 small mb-2">Status Surat</div>
              <select class="form-select" name="status">
                <option value="">Semua Status</option>
                @foreach ($statusOptions as $status)
                  <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-lg-3">
              <div class="fw-bold text-gray-700 small mb-2">Rentang Tanggal</div>
              <div class="d-flex gap-2">
                <div class="input-group">
                  <input class="form-control" type="date" name="date_start" value="{{ request('date_start') }}" />
                  <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                </div>
                <div class="input-group">
                  <input class="form-control" type="date" name="date_end" value="{{ request('date_end') }}" />
                  <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                </div>
              </div>
            </div>
            <div class="col-12 d-flex justify-content-end">
              <a class="btn text-white bg-[#ff7f00] hover:bg-[#f36f00] border-0 fw-bold" href="{{ route('cari-arsip') }}">
                <i class="bi bi-arrow-counterclockwise me-2"></i> Reset Filter
              </a>
            </div>
          </div>
        </div>
      </section>
    </form>

    <section class="card border-0 shadow-sm mt-3">
      <div class="card-body pb-0">
        <div class="fw-bold text-gray-900">Hasil Pencarian Arsip</div>
        <div class="text-muted small">
          @if ($archives->total() > 0)
            Menampilkan {{ $archives->firstItem() }}-{{ $archives->lastItem() }} dari {{ $archives->total() }} arsip ditemukan
          @else
            Belum ada arsip ditemukan
          @endif
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="min-w-[150px]">Nomor Surat</th>
              <th class="min-w-[130px]">Tanggal</th>
              <th class="min-w-[130px]">Jenis</th>
              <th>Perihal</th>
              <th>Instansi</th>
              <th class="min-w-[120px]">Status</th>
              <th class="min-w-[130px] text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($archives as $archive)
              @php
                $jenisClass = $jenisClasses[$archive->jenis] ?? 'badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle';
                $statusKey = strtolower($archive->status ?? '');
                $statusClass = $statusClasses[$statusKey] ?? 'badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle';
                $detailUrl = match ($archive->source) {
                  'incoming' => route('detail-surat-masuk', $archive->id),
                  'outgoing' => route('detail-surat-keluar', $archive->id),
                  default => route('archives.show', $archive->id),
                };
              @endphp
              <tr>
                <td>{{ $archive->nomor_surat }}</td>
                <td class="text-muted">{{ optional($archive->tanggal_surat)->format('d M Y') }}</td>
                <td><span class="{{ $jenisClass }}">{{ $archive->jenis ?? '-' }}</span></td>
                <td class="text-muted">{{ $archive->perihal }}</td>
                <td class="text-muted">{{ $archive->instansi ?? '-' }}</td>
                <td><span class="{{ $statusClass }}">{{ ucfirst($archive->status ?? '-') }}</span></td>
                <td class="text-end">
                  <a class="btn btn-sm fw-bold !text-white !bg-orange-500 hover:!bg-orange-600 !border-0" href="{{ $detailUrl }}">Lihat Detail</a>
                </td>
              </tr>
            @empty
              <tr>
                <td class="text-muted text-center" colspan="7">Belum ada arsip yang sesuai.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center px-3 py-3">
        <div class="text-muted small fw-bold">
          @if ($archives->total() > 0)
            Menampilkan hasil dari {{ $archives->firstItem() }} sampai {{ $archives->lastItem() }}
          @else
            Belum ada hasil
          @endif
        </div>
        <nav>
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item {{ $archives->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link" href="{{ $archives->previousPageUrl() ?? '#' }}" aria-label="Prev">
                <i class="bi bi-chevron-left"></i>
              </a>
            </li>
            <li class="page-item active"><span class="page-link">{{ $archives->currentPage() }}</span></li>
            <li class="page-item {{ $archives->hasMorePages() ? '' : 'disabled' }}">
              <a class="page-link" href="{{ $archives->nextPageUrl() ?? '#' }}" aria-label="Next">
                <i class="bi bi-chevron-right"></i>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </section>

    @if ($canInputLetter)
      <section class="card border-0 shadow-sm mt-3">
        <div class="card-body">
          <div class="fw-bold text-gray-900 mb-3">Aksi Cepat</div>
          <div class="d-flex flex-wrap gap-2">
            <a class="btn text-white bg-[#ff7f00] hover:bg-[#f36f00] border-0 fw-bold" href="{{ route('tambah-surat-masuk') }}">
              <i class="bi bi-inbox me-2"></i> Input Surat Masuk
            </a>
            <a class="btn text-white bg-[#4b5563] hover:bg-[#374151] border-0 fw-bold" href="{{ route('tambah-surat-keluar') }}">
              <i class="bi bi-send me-2"></i> Buat Surat Keluar
            </a>
          </div>
        </div>
      </section>
    @endif
  </main>
</x-app-layout>




