@push('styles')
@endpush

<x-app-layout>
  @php
    $canInputLetter = Auth::user()->hasAnyRole(['sekretariat', 'admin']);
    $quickActions = [
      ['id' => 'create', 'icon' => 'bi-file-earmark-plus', 'title' => 'Buat Surat Baru', 'desc' => 'Buat surat keluar baru', 'href' => route('tambah-surat')],
      ['id' => 'incoming', 'icon' => 'bi-inbox', 'title' => 'Input Surat Masuk', 'desc' => 'Catat surat masuk baru', 'href' => route('tambah-surat-masuk')],
      ['id' => 'archives', 'icon' => 'bi-search', 'title' => 'Arsip Digital', 'desc' => 'Telusuri arsip surat', 'href' => route('cari-arsip')],
      ['id' => 'reports', 'icon' => 'bi-bar-chart', 'title' => 'Lihat Laporan', 'desc' => 'Statistik dan laporan', 'href' => route('surat-masuk.index')],
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
            <a href="{{ $action['href'] }}" class="bg-orange-50 border border-orange-100 rounded-2xl p-4 flex gap-3 hover:border-orange-200 hover:bg-orange-100/70 transition">
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
              <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $activity['pillClass'] }}">{{ $activity['status'] }}</span>
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
          <table class="min-w-full text-sm">
            <thead>
              <tr class="text-left text-gray-500 bg-[#f5f7fb]">
                <th class="py-3 px-4 font-bold">No. Surat</th>
                <th class="py-3 px-4 font-bold">Tanggal</th>
                <th class="py-3 px-4 font-bold">Perihal</th>
                <th class="py-3 px-4 font-bold">Jenis</th>
                <th class="py-3 px-4 font-bold text-center">Status</th>
                <th class="py-3 px-4 font-bold text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @forelse ($latestLetters as $letter)
                <tr>
                  <td class="py-3 px-4 bg-gray-50">{{ $letter['no'] }}</td>
                  <td class="py-3 px-4 bg-gray-50">{{ $letter['date'] }}</td>
                  <td class="py-3 px-4 bg-gray-50">{{ $letter['subject'] }}</td>
                  <td class="py-3 px-4 bg-gray-50">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-extrabold {{ $letter['typeClass'] }}">
                      {{ $letter['type'] }}
                    </span>
                  </td>
                  <td class="py-3 px-4 bg-gray-50 text-center">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold border {{ $letter['statusClass'] }}">
                      {{ $letter['status'] }}
                    </span>
                  </td>
                  <td class="py-3 px-4 bg-gray-50 text-right">
                    <a class="btn btn-sm fw-bold !text-white !bg-orange-500 hover:!bg-orange-600 !border-0" href="{{ $letter['link'] }}">Lihat Detail</a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td class="py-3 px-4 bg-gray-50 text-center text-gray-500" colspan="6">Belum ada surat terbaru.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>
    </main>

  </div>
</x-app-layout>





