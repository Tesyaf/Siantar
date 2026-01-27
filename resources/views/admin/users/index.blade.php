<x-app-layout>
  @php
  $roleClasses = [
  'admin' => 'badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle',
  'sekretariat' => 'badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle',
  'sekretaris' => 'badge rounded-pill bg-info-subtle text-info border border-info-subtle',
  'kepala_badan' => 'badge rounded-pill bg-success-subtle text-success border border-success-subtle',
  ];
  @endphp

  <main class="container py-4">
    <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none fw-semibold d-inline-flex align-items-center gap-2 hover:text-gray-800">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <div class="d-flex flex-wrap justify-content-between align-items-center mt-2 gap-3">
      <div>
        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Kelola Pengguna</h1>
        <p class="text-gray-500 mb-0">Atur akun, peran, dan akses pengguna sistem.</p>
      </div>
      <a href="{{ route('admin.users.create') }}" class="btn text-white border-0 fw-bold" style="background-color: #ff7f00;">
        <i class="bi bi-person-plus me-2"></i> Tambah Pengguna
      </a>
    </div>

    @if (session('success'))
    <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div>
    @endif

    <form class="card border-0 shadow-sm mt-4" method="GET" action="{{ route('admin.users.index') }}">
      <div class="card-body">
        <div class="row g-3">
          <div class="col-lg-5">
            <div class="fw-bold text-gray-700 small mb-2">Pencarian</div>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input class="form-control" type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, username, email, atau NIP..." />
            </div>
          </div>
          <div class="col-lg-3">
            <div class="fw-bold text-gray-700 small mb-2">Role</div>
            <select class="form-select" name="role">
              <option value="">Semua Role</option>
              @foreach ($roleOptions as $roleValue => $roleLabel)
              <option value="{{ $roleValue }}" @selected(request('role')===$roleValue)>{{ $roleLabel }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-lg-2 d-flex align-items-end">
            <button class="btn text-white border-0 fw-bold w-100" style="background-color: #ff7f00;" type="submit">
              <i class="bi bi-filter me-2"></i>Terapkan
            </button>
          </div>
          <div class="col-lg-2 d-flex align-items-end">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary fw-bold w-100">
              <i class="bi bi-arrow-clockwise me-2"></i>Reset
            </a>
          </div>
        </div>
      </div>
    </form>

    <section class="card border-0 shadow-sm mt-4">
      <div class="card-body p-0 p-lg-3">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" data-sortable>
            <thead class="table-light">
              <tr>
                <th class="min-w-[200px]" data-sortable-col>
                  <button type="button" class="btn btn-link p-0 text-decoration-none text-dark fw-bold" data-sort-button>
                    Nama <span class="text-muted ms-1" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="min-w-[160px]" data-sortable-col>
                  <button type="button" class="btn btn-link p-0 text-decoration-none text-dark fw-bold" data-sort-button>
                    Username <span class="text-muted ms-1" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="min-w-[220px]" data-sortable-col>
                  <button type="button" class="btn btn-link p-0 text-decoration-none text-dark fw-bold" data-sort-button>
                    Email <span class="text-muted ms-1" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="min-w-[160px]" data-sortable-col>
                  <button type="button" class="btn btn-link p-0 text-decoration-none text-dark fw-bold" data-sort-button>
                    Role <span class="text-muted ms-1" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="min-w-[140px]" data-sortable-col data-sort-type="number">
                  <button type="button" class="btn btn-link p-0 text-decoration-none text-dark fw-bold" data-sort-button>
                    NIP <span class="text-muted ms-1" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="min-w-[140px]" data-sortable-col data-sort-type="date">
                  <button type="button" class="btn btn-link p-0 text-decoration-none text-dark fw-bold" data-sort-button>
                    Dibuat <span class="text-muted ms-1" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="min-w-[160px] text-center text-muted"></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($users as $user)
              <tr>
                <td class="fw-bold">
                  {{ $user->name }}
                  @if ($user->is(auth()->user()))
                  <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle ms-2">Anda</span>
                  @endif
                </td>
                <td class="text-muted">{{ $user->username }}</td>
                <td class="text-muted">{{ $user->email }}</td>
                <td>
                  <span class="{{ $roleClasses[$user->role] ?? 'badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle' }}">
                    {{ $user->roleLabel() }}
                  </span>
                </td>
                <td class="text-muted">{{ $user->nip ?? '-' }}</td>
                <td class="text-muted" data-sort-value="{{ optional($user->created_at)->format('Y-m-d') }}">{{ optional($user->created_at)->format('d M Y') }}</td>
                <td class="text-center">
                  <div class="d-inline-flex gap-2">
                    <a class="btn btn-sm fw-bold !text-white !bg-orange-500 hover:!bg-orange-600 !border-0" href="{{ route('admin.users.edit', $user) }}">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm fw-bold btn-outline-danger">Hapus</button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td class="text-center text-muted" colspan="7">Belum ada pengguna.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-3 px-3 pb-3">
        <div class="text-muted small">
          @if ($users->total() > 0)
          Menampilkan {{ $users->firstItem() }}-{{ $users->lastItem() }} dari {{ $users->total() }} pengguna
          @else
          Belum ada pengguna
          @endif
        </div>
        <nav>
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link" href="{{ $users->previousPageUrl() ?? '#' }}" aria-label="Prev">
                <i class="bi bi-chevron-left"></i>
              </a>
            </li>
            <li class="page-item active"><span class="page-link">{{ $users->currentPage() }}</span></li>
            <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
              <a class="page-link" href="{{ $users->nextPageUrl() ?? '#' }}" aria-label="Next">
                <i class="bi bi-chevron-right"></i>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </section>
  </main>
</x-app-layout>
