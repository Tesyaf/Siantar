<x-app-layout>
  @php
  $statusClasses = [
  'Menunggu' => 'badge rounded-pill bg-amber-100 text-amber-700 border border-amber-200',
  'Diproses' => 'badge rounded-pill bg-orange-100 text-orange-700 border border-orange-200',
  'Terkirim' => 'badge rounded-pill bg-green-100 text-green-700 border border-green-200',
  'Selesai' => 'badge rounded-pill bg-green-100 text-green-700 border border-green-200',
  ];
  @endphp

  <div class="min-h-screen bg-[#f5f7fb]">
    <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6">

      <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-orange-500 font-semibold text-sm no-underline transition-colors">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
      </a>

      <h1 class="mt-4 mb-1 text-2xl font-extrabold text-gray-900">Surat Keluar</h1>
      <p class="text-gray-500 text-sm mb-6">Daftar seluruh surat keluar yang Anda kirim</p>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 flex items-center justify-between">
          <div>
            <div class="text-gray-500 text-xs font-bold uppercase tracking-wide">Total Surat Keluar</div>
            <div class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['total'] }}</div>
          </div>
          <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center">
            <i class="bi bi-send-fill text-orange-500 text-xl"></i>
          </div>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 flex items-center justify-between">
          <div>
            <div class="text-gray-500 text-xs font-bold uppercase tracking-wide">Menunggu Persetujuan</div>
            <div class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['pending'] }}</div>
          </div>
          <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
            <i class="bi bi-clock-fill text-amber-500 text-xl"></i>
          </div>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 flex items-center justify-between">
          <div>
            <div class="text-gray-500 text-xs font-bold uppercase tracking-wide">Sudah Dikirim</div>
            <div class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['sent'] }}</div>
          </div>
          <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center">
            <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
          </div>
        </div>
      </div>

      <form x-data="{ loading: false }" x-ref="filterForm" class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 mb-4" method="GET" action="{{ route('surat-keluar.index') }}">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
          <div class="md:col-span-5">
            <label class="block text-xs font-bold text-gray-700 mb-2">Pencarian</label>
            <div class="relative">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="bi bi-search"></i></span>
              <input x-on:input.debounce.400ms="loading = true; $refs.filterForm.submit()" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor surat atau perihal..." />
            </div>
          </div>
          <div class="md:col-span-3">
            <label class="block text-xs font-bold text-gray-700 mb-2">Status</label>
            <select x-on:change="loading = true; $refs.filterForm.submit()" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition appearance-none bg-white" name="status">
              <option value="">Semua Status</option>
              @foreach ($statusOptions as $status)
              <option value="{{ $status }}" @selected(request('status')===$status)>{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="md:col-span-2">
            <label class="block text-xs font-bold text-gray-700 mb-2">Bulan</label>
            <input x-on:change="loading = true; $refs.filterForm.submit()" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" type="month" name="month" value="{{ request('month') }}" />
          </div>
          <div class="md:col-span-2 flex items-end">
            <a :class="{ 'opacity-50 pointer-events-none': loading }" class="w-full text-center bg-gray-100 text-gray-700 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-200 transition text-sm no-underline" href="{{ route('surat-keluar.index') }}">
              <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
            </a>
          </div>
        </div>
        <div x-show="loading" class="flex items-center justify-center mt-4">
          <div class="animate-spin rounded-full h-5 w-5 border-2 border-orange-500 border-t-transparent"></div>
          <span class="ml-2 text-sm text-gray-500">Memuat...</span>
        </div>
      </form>

      <section class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-gray-50 text-left">
                <th class="py-4 px-5 font-bold text-gray-700 min-w-[140px]">Nomor Surat</th>
                <th class="py-4 px-5 font-bold text-gray-700 min-w-[120px]">Tanggal</th>
                <th class="py-4 px-5 font-bold text-gray-700 min-w-[160px]">Penerima</th>
                <th class="py-4 px-5 font-bold text-gray-700">Perihal</th>
                <th class="py-4 px-5 font-bold text-gray-700 text-center min-w-[120px]">Status</th>
                <th class="py-4 px-5 font-bold text-gray-700 text-center min-w-[130px]">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @forelse ($letters as $letter)
              @php
              $status = $letter->status ?? 'Menunggu';
              @endphp
              <tr class="hover:bg-orange-50/30 transition-colors">
                <td class="py-4 px-5 font-bold text-gray-900">{{ $letter->letter_number }}</td>
                <td class="py-4 px-5 text-gray-500">{{ optional($letter->letter_date)->format('d M Y') }}</td>
                <td class="py-4 px-5 text-gray-500">{{ $letter->recipient }}</td>
                <td class="py-4 px-5 text-gray-600">{{ $letter->subject }}</td>
                <td class="py-4 px-5 text-center"><span class="{{ $statusClasses[$status] ?? $statusClasses['Menunggu'] }}">{{ $status }}</span></td>
                <td class="py-4 px-5 text-center">
                  <a class="inline-block bg-orange-500 text-white font-bold text-xs px-4 py-2 rounded-lg hover:bg-orange-600 transition no-underline" href="{{ route('detail-surat-keluar', $letter) }}">Lihat Detail</a>
                </td>
              </tr>
              @empty
              <tr>
                <td class="py-8 px-5 text-center text-gray-400" colspan="6">Belum ada surat keluar.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="flex items-center justify-between px-5 py-4 border-t border-gray-100">
          <div class="text-gray-500 text-sm">
            @if ($letters->total() > 0)
            Menampilkan {{ $letters->firstItem() }}-{{ $letters->lastItem() }} dari {{ $letters->total() }} surat keluar
            @else
            Belum ada surat keluar
            @endif
          </div>
          <div class="flex items-center gap-1">
            <a href="{{ $letters->previousPageUrl() ?? '#' }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-orange-50 hover:text-orange-500 hover:border-orange-200 transition {{ $letters->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }} no-underline">
              <i class="bi bi-chevron-left"></i>
            </a>
            <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-orange-500 text-white font-bold text-sm">{{ $letters->currentPage() }}</span>
            <a href="{{ $letters->nextPageUrl() ?? '#' }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-orange-50 hover:text-orange-500 hover:border-orange-200 transition {{ $letters->hasMorePages() ? '' : 'opacity-50 pointer-events-none' }} no-underline">
              <i class="bi bi-chevron-right"></i>
            </a>
          </div>
        </div>
      </section>

    </main>
  </div>
</x-app-layout>