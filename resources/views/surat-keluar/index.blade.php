<x-app-layout>
  <div class="min-h-screen bg-[#f5f7fb]">
    <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6">

      <a href="{{ route('dashboard') }}"
        class="inline-flex items-center gap-2 text-gray-500 hover:text-orange-500 font-semibold text-sm no-underline transition-colors">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
      </a>

      <h1 class="mt-4 mb-1 text-2xl font-extrabold text-gray-900">Surat Keluar</h1>
      <p class="text-gray-500 text-sm mb-6">Daftar seluruh surat keluar yang Anda kirim</p>

      @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm mb-4">
          {{ session('success') }}</div>
      @endif
      @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm mb-4">{{ session('error') }}
        </div>
      @endif

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
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
            <div class="text-gray-500 text-xs font-bold uppercase tracking-wide">Surat Keluar Baru (Hari Ini)</div>
            <div class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['today'] }}</div>
          </div>
          <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center">
            <i class="bi bi-stars text-green-600 text-xl"></i>
          </div>
        </div>
      </div>

      <form x-data="{ loading: false }" x-ref="filterForm"
        class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 mb-4" method="GET"
        action="{{ route('surat-keluar.index') }}">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
          <div class="md:col-span-5">
            <label class="block text-xs font-bold text-gray-700 mb-2">Pencarian</label>
            <div class="relative">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="bi bi-search"></i></span>
              <input x-on:input.debounce.400ms="loading = true; $refs.filterForm.submit()"
                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition"
                type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nomor surat atau perihal..." />
            </div>
          </div>
          <div class="md:col-span-3">
            <label class="block text-xs font-bold text-gray-700 mb-2">Bulan</label>
            <input x-on:change="loading = true; $refs.filterForm.submit()"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition"
              type="month" name="month" value="{{ request('month') }}" />
          </div>
          <div class="md:col-span-4 flex items-end">
            <a :class="{ 'opacity-50 pointer-events-none': loading }"
              class="w-full text-center bg-gray-100 text-gray-700 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-200 transition text-sm no-underline"
              href="{{ route('surat-keluar.index') }}">
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
          <table class="w-full text-sm" data-sortable>
            <thead>
              <tr class="bg-gray-50 text-left">
                <th class="py-4 px-5 font-bold text-gray-700 min-w-[110px]" data-sortable-col data-sort-type="number">
                  <button type="button" class="inline-flex items-center gap-2" data-sort-button>
                    No Index <span class="text-xs text-gray-400" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="py-4 px-5 font-bold text-gray-700 min-w-[140px]" data-sortable-col>
                  <button type="button" class="inline-flex items-center gap-2" data-sort-button>
                    Nomor Surat <span class="text-xs text-gray-400" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="py-4 px-5 font-bold text-gray-700 min-w-[120px]" data-sortable-col data-sort-type="date">
                  <button type="button" class="inline-flex items-center gap-2" data-sort-button>
                    Tanggal <span class="text-xs text-gray-400" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="py-4 px-5 font-bold text-gray-700 min-w-[160px]" data-sortable-col>
                  <button type="button" class="inline-flex items-center gap-2" data-sort-button>
                    Penerima <span class="text-xs text-gray-400" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="py-4 px-5 font-bold text-gray-700" data-sortable-col>
                  <button type="button" class="inline-flex items-center gap-2" data-sort-button>
                    Perihal <span class="text-xs text-gray-400" data-sort-indicator>↕</span>
                  </button>
                </th>
                <th class="py-4 px-5 font-bold text-gray-400 text-center min-w-[130px]"></th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @forelse ($letters as $letter)
                <tr class="hover:bg-orange-50/30 transition-colors cursor-pointer"
                  onclick="if(!event.target.closest('.action-menu')) window.location='{{ route('detail-surat-keluar', $letter) }}'">
                  <td class="py-4 px-5 text-gray-600">{{ $letter->index_no ?? '-' }}</td>
                  <td class="py-4 px-5 font-bold text-gray-900">{{ $letter->letter_number }}</td>
                  <td class="py-4 px-5 text-gray-500"
                    data-sort-value="{{ optional($letter->letter_date)->format('Y-m-d') }}">
                    {{ optional($letter->letter_date)->format('d M Y') }}</td>
                  <td class="py-4 px-5 text-gray-500">{{ $letter->recipient }}</td>
                  <td class="py-4 px-5 text-gray-600">{{ $letter->subject }}</td>
                  <td class="py-4 px-5 text-center">
                    <div x-data="actionDropdown()" class="relative inline-block action-menu">
                      <button x-ref="button" @click="toggle"
                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition text-gray-500">
                        <i class="bi bi-three-dots-vertical"></i>
                      </button>
                      <template x-teleport="body">
                        <div x-ref="menu" x-show="open" x-transition:enter="transition ease-out duration-100"
                          x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                          x-transition:leave="transition ease-in duration-75"
                          x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                          @click.outside="close" :style="style"
                          class="w-40 bg-white border border-gray-200 rounded-xl shadow-lg z-[9999] overflow-hidden">
                          <a href="{{ route('detail-surat-keluar', $letter) }}"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline">
                            <i class="bi bi-eye"></i> Lihat Detail
                          </a>
                          @if (auth()->user()->hasAnyRole(['sekretariat', 'admin']))
                            <a href="{{ route('surat-keluar.edit', $letter) }}"
                              class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline">
                              <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('surat-keluar.destroy', $letter) }}" method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                              @csrf
                              @method('DELETE')
                              <button type="submit"
                                class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                <i class="bi bi-trash"></i> Hapus
                              </button>
                            </form>
                          @endif
                        </div>
                      </template>
                    </div>
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
            {{-- Previous Button --}}
            <a href="{{ $letters->previousPageUrl() ?? '#' }}"
              class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-orange-50 hover:text-orange-500 hover:border-orange-200 transition {{ $letters->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }} no-underline">
              <i class="bi bi-chevron-left"></i>
            </a>

            {{-- Page Numbers --}}
            @php
              $currentPage = $letters->currentPage();
              $lastPage = $letters->lastPage();
              $start = max(1, $currentPage - 2);
              $end = min($lastPage, $currentPage + 2);

              // Adjust range to always show 5 pages if possible
              if ($end - $start < 4) {
                if ($start == 1) {
                  $end = min($lastPage, $start + 4);
                } elseif ($end == $lastPage) {
                  $start = max(1, $end - 4);
                }
              }
            @endphp

            {{-- First page + ellipsis --}}
            @if ($start > 1)
              <a href="{{ $letters->url(1) }}"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-orange-50 hover:text-orange-500 hover:border-orange-200 transition no-underline text-sm">1</a>
              @if ($start > 2)
                <span class="w-6 text-center text-gray-400">...</span>
              @endif
            @endif

            {{-- Page number buttons --}}
            @for ($page = $start; $page <= $end; $page++)
              @if ($page == $currentPage)
                <span
                  class="w-9 h-9 flex items-center justify-center rounded-lg bg-orange-500 text-white font-bold text-sm">{{ $page }}</span>
              @else
                <a href="{{ $letters->url($page) }}"
                  class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-orange-50 hover:text-orange-500 hover:border-orange-200 transition no-underline text-sm">{{ $page }}</a>
              @endif
            @endfor

            {{-- Last page + ellipsis --}}
            @if ($end < $lastPage)
              @if ($end < $lastPage - 1)
                <span class="w-6 text-center text-gray-400">...</span>
              @endif
              <a href="{{ $letters->url($lastPage) }}"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-orange-50 hover:text-orange-500 hover:border-orange-200 transition no-underline text-sm">{{ $lastPage }}</a>
            @endif

            {{-- Next Button --}}
            <a href="{{ $letters->nextPageUrl() ?? '#' }}"
              class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-orange-50 hover:text-orange-500 hover:border-orange-200 transition {{ $letters->hasMorePages() ? '' : 'opacity-50 pointer-events-none' }} no-underline">
              <i class="bi bi-chevron-right"></i>
            </a>
          </div>
        </div>
      </section>

    </main>
  </div>
</x-app-layout>