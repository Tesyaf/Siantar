@push('styles')
@endpush

<x-app-layout>
  @php
  $userRole = Auth::user()->role;
  @endphp

  @if($userRole === 'kepala_badan')
  @include('dashboard.partials.dashboard-kepala-badan', compact('incomingStats', 'outgoingStats', 'activities', 'latestLetters'))
  @elseif($userRole === 'sekretaris')
  @include('dashboard.partials.dashboard-sekretaris', compact('incomingStats', 'outgoingStats', 'activities', 'latestLetters'))
  @elseif($userRole === 'admin')
  @include('dashboard.partials.dashboard-admin', compact('incomingStats', 'outgoingStats', 'activities', 'latestLetters'))
  @else
  <!-- DEFAULT VIEW (untuk role lain seperti sekretariat) -->
  @php
  $canInputLetter = Auth::user()->hasAnyRole(['sekretariat', 'admin']);
  $quickActions = [
  ['id' => 'create', 'icon' => 'bi-file-earmark-plus', 'title' => 'Buat Surat Baru', 'desc' => 'Buat surat keluar baru', 'href' => route('tambah-surat')],
  ['id' => 'incoming', 'icon' => 'bi-inbox', 'title' => 'Input Surat Masuk', 'desc' => 'Catat surat masuk baru', 'href' => route('tambah-surat-masuk')],
  ['id' => 'archives', 'icon' => 'bi-search', 'title' => 'Arsip Digital', 'desc' => 'Telusuri arsip surat', 'href' => route('cari-arsip')],
  ['id' => 'reports', 'icon' => 'bi-bar-chart', 'title' => 'Lihat Laporan', 'desc' => 'Statistik dan laporan', 'href' => route('laporan.index')],
  ];

  if (!$canInputLetter) {
  $quickActions = array_filter($quickActions, fn ($action) => !in_array($action['id'], ['create', 'incoming'], true));
  }
  @endphp

  <div class="min-h-screen bg-[#f5f7fb] text-gray-900">
    <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6 space-y-4">
      <!-- HERO -->
      <section class="rounded-2xl p-6 text-white shadow-[0_10px_30px_rgba(17,24,39,0.06)] bg-[linear-gradient(90deg,#ff7a00_0%,#ff8b1a_55%,#ff9b2b_100%)]">
        <h4 class="text-xl font-extrabold tracking-tight">Selamat Datang di SIANTAR, {{ Auth::user()->name ?? 'Pengguna' }}</h4>
        <p class="text-sm font-medium mt-1">Kelola surat masuk dan keluar dengan mudah dan efisien</p>
        <small class="text-[12px] text-orange-100 mt-2 block">Badan Kesatuan Bangsa dan Politik (Kesbangpol)</small>
      </section>

      <!-- QUICK ACTIONS -->
      <section>
        <h6 class="font-bold mb-3">Aksi Cepat</h6>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          @foreach ($quickActions as $action)
          <a href="{{ $action['href'] }}" class="bg-orange-50 border border-orange-100 rounded-2xl p-4 flex gap-3 text-gray-900 no-underline hover:border-orange-200 hover:bg-orange-100/70 transition">
            <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-500 grid place-items-center text-lg flex-shrink-0">
              <i class="bi {{ $action['icon'] }}"></i>
            </div>
            <div>
              <p class="font-extrabold text-sm">{{ $action['title'] }}</p>
              <p class="text-xs text-gray-500 mt-1">{{ $action['desc'] }}</p>
            </div>
          </a>
          @endforeach
        </div>
      </section>

      <!-- SUMMARY CARDS -->
      <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white border border-[#e6eaf2] rounded-[14px] shadow-[0_8px_20px_rgba(17,24,39,0.05)] p-6">
          <div class="flex gap-3 items-start">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 grid place-items-center text-lg">
              <i class="bi bi-inbox-fill"></i>
            </div>
            <div>
              <div class="text-[15px] font-extrabold">Surat Masuk</div>
              <div class="text-xs text-gray-500 mt-1">Kelola surat yang diterima</div>
            </div>
          </div>

          @foreach ($incomingStats as $stat)
          <div class="mt-3 flex items-center justify-between rounded-xl px-3 py-2 text-sm {{ $stat['rowClass'] }}">
            <div class="flex items-center gap-2 font-medium text-gray-700">
              <span class="text-base {{ $stat['iconClass'] }}"><i class="bi {{ $stat['icon'] }}"></i></span>
              <span>{{ $stat['label'] }}</span>
            </div>
            <strong class="{{ $stat['valueClass'] }}">{{ $stat['value'] }}</strong>
          </div>
          @endforeach

          <a href="{{ route('surat-masuk.index') }}" class="mt-4 w-full rounded-xl bg-orange-500 text-white font-bold py-3 shadow-[0_10px_18px_rgba(255,127,0,0.22)] hover:bg-orange-600 text-center block">
            Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
          </a>
        </div>

        <div class="bg-white border border-[#e6eaf2] rounded-[14px] shadow-[0_8px_20px_rgba(17,24,39,0.05)] p-6">
          <div class="flex gap-3 items-start">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 grid place-items-center text-lg">
              <i class="bi bi-send-fill"></i>
            </div>
            <div>
              <div class="text-[15px] font-extrabold">Surat Keluar</div>
              <div class="text-xs text-gray-500 mt-1">Kelola surat yang dikirim</div>
            </div>
          </div>

          @foreach ($outgoingStats as $stat)
          <div class="mt-3 flex items-center justify-between rounded-xl px-3 py-2 text-sm {{ $stat['rowClass'] }}">
            <div class="flex items-center gap-2 font-medium text-gray-700">
              <span class="text-base {{ $stat['iconClass'] }} {{ !empty($stat['rotate']) ? '-rotate-180' : '' }}">
                <i class="bi {{ $stat['icon'] }}"></i>
              </span>
              <span>{{ $stat['label'] }}</span>
            </div>
            <strong class="{{ $stat['valueClass'] }}">{{ $stat['value'] }}</strong>
          </div>
          @endforeach

          <a href="{{ route('surat-keluar.index') }}" class="mt-4 w-full rounded-xl bg-orange-500 text-white font-bold py-3 shadow-[0_10px_18px_rgba(255,127,0,0.22)] hover:bg-orange-600 text-center block">
            Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
          </a>
        </div>
      </section>

      <!-- ACTIVITY -->
      <section class="bg-white border border-[#e6eaf2] rounded-[14px] shadow-[0_8px_20px_rgba(17,24,39,0.05)] p-6">
        <div class="flex items-center justify-between mb-3">
          <h6 class="font-extrabold">Aktivitas Terbaru</h6>
          <div class="text-sm text-gray-400">Hari ini</div>
        </div>

        <div class="space-y-2">
          @forelse ($activities as $activity)
          <div class="flex items-center justify-between gap-4 px-2 py-3 border-t border-gray-100 bg-gray-50 first:border-t-0 rounded-lg">
            <div class="flex items-center gap-3">
              <div class="w-9 h-9 rounded-full grid place-items-center {{ $activity['iconClass'] }}">
                <i class="bi {{ $activity['icon'] }}"></i>
              </div>
              <div>
                <p class="text-sm font-bold">{{ $activity['title'] }}</p>
                <p class="text-xs text-gray-400">{{ $activity['time'] }}</p>
              </div>
            </div>
          </div>
          @empty
          <div class="text-sm text-gray-500">Belum ada aktivitas terbaru.</div>
          @endforelse
        </div>
      </section>

      <!-- LATEST LETTERS -->
      <section class="bg-white border border-[#e6eaf2] rounded-[14px] shadow-[0_8px_20px_rgba(17,24,39,0.05)] p-6">
        <div class="flex items-start justify-between flex-wrap gap-2 mb-4">
          <div>
            <h6 class="font-bold">Surat Terbaru</h6>
            <div class="text-sm text-gray-400">5 surat terakhir yang masuk ke sistem</div>
          </div>
          @if ($canInputLetter)
          <a href="{{ route('tambah-surat') }}" class="rounded-xl bg-orange-500 text-white font-extrabold px-4 py-2 shadow-[0_10px_18px_rgba(255,127,0,0.22)] hover:bg-orange-600">
            <i class="bi bi-plus-lg me-1"></i> Tambah Surat
          </a>
          @endif
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm table-fixed" data-sortable>
            <thead>
              <tr class="text-left text-gray-500 bg-[#f5f7fb]">
                <th class="py-3 px-4 font-bold" data-sortable-col>
                  <button type="button" class="inline-flex items-center gap-2" data-sort-button>
                    No. Surat <span class="text-xs text-gray-400" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="py-3 px-4 font-bold" data-sortable-col data-sort-type="date">
                  <button type="button" class="inline-flex items-center gap-2" data-sort-button>
                    Tanggal <span class="text-xs text-gray-400" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="py-3 px-4 font-bold" data-sortable-col>
                  <button type="button" class="inline-flex items-center gap-2" data-sort-button>
                    Perihal <span class="text-xs text-gray-400" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="py-3 px-4 font-bold" data-sortable-col>
                  <button type="button" class="inline-flex items-center gap-2" data-sort-button>
                    Jenis <span class="text-xs text-gray-400" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="py-3 px-4 font-bold text-right text-gray-400 w-16"></th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @forelse ($latestLetters as $letter)
              <tr>
                <td class="py-3 px-4 bg-gray-50">{{ $letter['no'] }}</td>
                <td class="py-3 px-4 bg-gray-50" data-sort-value="{{ $letter['date_sort'] ? \Carbon\Carbon::parse($letter['date_sort'])->format('Y-m-d') : '' }}">{{ $letter['date'] }}</td>
                <td class="py-3 px-4 bg-gray-50">{{ $letter['subject'] }}</td>
                <td class="py-3 px-4 bg-gray-50">
                  <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-extrabold {{ $letter['typeClass'] }}">
                    {{ $letter['type'] }}
                  </span>
                </td>
                <td class="py-3 px-4 bg-gray-50 text-right w-16">
                  <div x-data="{ open: false }" class="relative inline-block action-menu">
                    <button @click="open = !open" @click.outside="open = false" class="w-8 h-8 inline-flex items-center justify-center rounded-lg hover:bg-gray-100 transition text-gray-500">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-1 w-44 bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden">
                      <a href="{{ $letter['link'] }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline">
                        <i class="bi bi-eye"></i> Lihat Detail
                      </a>
                      @if (auth()->user()->hasAnyRole(['sekretariat', 'admin']))
                      <a href="{{ $letter['type'] === 'Masuk' ? route('surat-masuk.edit', $letter['id']) : route('surat-keluar.edit', $letter['id']) }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline">
                        <i class="bi bi-pencil"></i> Edit
                      </a>
                      <form action="{{ $letter['type'] === 'Masuk' ? route('surat-masuk.destroy', $letter['id']) : route('surat-keluar.destroy', $letter['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                          <i class="bi bi-trash"></i> Hapus
                        </button>
                      </form>
                      @endif
                    </div>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td class="py-3 px-4 bg-gray-50 text-center text-gray-500" colspan="5">Belum ada surat terbaru.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>
    </main>

  </div>
  @endif
</x-app-layout>
