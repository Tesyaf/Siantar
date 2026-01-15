<x-app-layout>
  @php
  $canInputLetter = Auth::user()->hasAnyRole(['sekretariat', 'admin']);
  $jenisClasses = [
  'Surat Masuk' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200',
  'Surat Keluar' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200',
  ];
  $statusClasses = [
  'aktif' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200',
  'arsip' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200',
  'baru' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-700 border border-sky-200',
  'menunggu' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200',
  'diproses' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700 border border-orange-200',
  'terkirim' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-100 text-teal-700 border border-teal-200',
  'selesai' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200',
  ];
  @endphp
  <div class="min-h-screen bg-[#f5f7fb]">
    <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6">
      <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-orange-500 font-semibold text-sm no-underline transition-colors">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
      </a>

      <div class="flex items-center justify-between mt-6 mb-6">
        <div class="text-center flex-1">
          <h1 class="text-2xl font-extrabold text-gray-900">Arsip Digital</h1>
          <p class="text-gray-500 text-sm mt-1">Telusuri arsip surat masuk dan surat keluar dengan mudah</p>
        </div>
        <a href="{{ route('laporan.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-orange-500 text-white rounded-xl text-sm font-bold hover:bg-orange-600 transition no-underline">
          <i class="bi bi-file-earmark-bar-graph"></i> Buat Laporan
        </a>
      </div>

      <form x-data="{ loading: false }" x-ref="filterForm" method="GET" action="{{ route('cari-arsip') }}">
        <section class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 mb-4">
          <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="bi bi-search text-lg"></i></span>
            <input x-on:input.debounce.400ms="loading = true; $el.closest('form').submit()" class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nomor surat, perihal, atau instansi..." />
          </div>
          <div x-show="loading" class="flex items-center justify-center mt-4">
            <div class="animate-spin rounded-full h-5 w-5 border-2 border-orange-500 border-t-transparent"></div>
            <span class="ml-2 text-sm text-gray-500">Mencari...</span>
          </div>
        </section>

        <section class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-4 overflow-visible">
          <div class="flex flex-wrap items-end gap-4">
            {{-- Jenis Dropdown --}}
            <div class="flex-1 min-w-[140px]" x-data="{
              open: false,
              search: '{{ request('jenis') }}',
              selected: '{{ request('jenis') }}',
              options: @js(array_merge([''], is_array($jenisOptions) ? $jenisOptions : $jenisOptions->toArray())),
              get filtered() {
                if (!this.search) return this.options;
                return this.options.filter(o => o.toLowerCase().includes(this.search.toLowerCase()));
              },
              select(val) {
                this.selected = val;
                this.search = val;
                this.open = false;
                $nextTick(() => $el.closest('form').submit());
              }
            }" @click.outside="open = false">
              <label class="block text-xs font-bold text-gray-700 mb-2">Jenis</label>
              <div class="relative">
                <input type="text" x-model="search" @focus="open = true" @input="open = true"
                  @keydown.enter.prevent="if(filtered.length) select(filtered[0])"
                  @keydown.escape="open = false"
                  class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition bg-white" placeholder="Semua" autocomplete="off" />
                <input type="hidden" name="jenis" :value="selected" />
                <div x-show="open && filtered.length" x-transition class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-48 overflow-y-auto">
                  <template x-for="opt in filtered" :key="opt">
                    <div @click="select(opt)" class="px-4 py-2 text-sm cursor-pointer hover:bg-orange-50 hover:text-orange-600" :class="{ 'bg-orange-50 text-orange-600': selected === opt }" x-text="opt || 'Semua'"></div>
                  </template>
                </div>
              </div>
            </div>

            {{-- Kategori Dropdown --}}
            <div class="flex-1 min-w-[140px]" x-data="{
              open: false,
              search: '{{ request('folder') }}',
              selected: '{{ request('folder') }}',
              options: @js(array_merge([''], is_array($folderOptions) ? $folderOptions : $folderOptions->toArray())),
              get filtered() {
                if (!this.search) return this.options;
                return this.options.filter(o => o.toLowerCase().includes(this.search.toLowerCase()));
              },
              select(val) {
                this.selected = val;
                this.search = val;
                this.open = false;
                $nextTick(() => $el.closest('form').submit());
              }
            }" @click.outside="open = false">
              <label class="block text-xs font-bold text-gray-700 mb-2">Kategori</label>
              <div class="relative">
                <input type="text" x-model="search" @focus="open = true" @input="open = true"
                  @keydown.enter.prevent="if(filtered.length) select(filtered[0])"
                  @keydown.escape="open = false"
                  class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition bg-white" placeholder="Semua" autocomplete="off" />
                <input type="hidden" name="folder" :value="selected" />
                <div x-show="open && filtered.length" x-transition class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-48 overflow-y-auto">
                  <template x-for="opt in filtered" :key="opt">
                    <div @click="select(opt)" class="px-4 py-2 text-sm cursor-pointer hover:bg-orange-50 hover:text-orange-600" :class="{ 'bg-orange-50 text-orange-600': selected === opt }" x-text="opt || 'Semua'"></div>
                  </template>
                </div>
              </div>
            </div>

            <div class="flex-1 min-w-[140px]">
              <label class="block text-xs font-bold text-gray-700 mb-2">Dari</label>
              <input x-on:change="loading = true; $el.closest('form').submit()" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" type="date" name="date_start" value="{{ request('date_start') }}" />
            </div>
            <div class="flex-1 min-w-[140px]">
              <label class="block text-xs font-bold text-gray-700 mb-2">Sampai</label>
              <input x-on:change="loading = true; $el.closest('form').submit()" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" type="date" name="date_end" value="{{ request('date_end') }}" />
            </div>
            <div>
              <a :class="{ 'opacity-50 pointer-events-none': loading }" class="inline-flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition no-underline" href="{{ route('cari-arsip') }}" title="Reset Filter">
                <i class="bi bi-arrow-counterclockwise"></i>
              </a>
            </div>
          </div>
        </section>
      </form>

      <section class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-4">
        <div class="px-5 py-4 border-b border-gray-100">
          <div class="font-bold text-gray-900">Hasil Pencarian Arsip</div>
          <div class="text-gray-500 text-sm mt-1">
            @if ($archives->total() > 0)
            Menampilkan {{ $archives->firstItem() }}-{{ $archives->lastItem() }} dari {{ $archives->total() }} arsip ditemukan
            @else
            Belum ada arsip ditemukan
            @endif
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-gray-50 text-left">
                <th class="py-4 px-5 font-bold text-gray-700">Nomor Surat</th>
                <th class="py-4 px-5 font-bold text-gray-700">Tanggal</th>
                <th class="py-4 px-5 font-bold text-gray-700">Jenis</th>
                <th class="py-4 px-5 font-bold text-gray-700">Perihal</th>
                <th class="py-4 px-5 font-bold text-gray-700">Instansi</th>
                <th class="py-4 px-5 font-bold text-gray-700 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @forelse ($archives as $archive)
              @php
              $jenisClass = $jenisClasses[$archive->jenis] ?? 'inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200';
              $detailUrl = match ($archive->source) {
              'incoming' => route('detail-surat-masuk', $archive->id),
              'outgoing' => route('detail-surat-keluar', $archive->id),
              default => route('archives.show', $archive->id),
              };
              @endphp
              <tr class="hover:bg-orange-50/30 transition-colors">
                <td class="py-4 px-5 font-bold text-gray-900">{{ $archive->nomor_surat }}</td>
                <td class="py-4 px-5 text-gray-500 whitespace-nowrap">{{ optional($archive->tanggal_surat)->format('d M Y') }}</td>
                <td class="py-4 px-5"><span class="{{ $jenisClass }} whitespace-nowrap">{{ $archive->jenis ?? '-' }}</span></td>
                <td class="py-4 px-5 text-gray-600">{{ $archive->perihal }}</td>
                <td class="py-4 px-5 text-gray-500">{{ $archive->instansi ?? '-' }}</td>
                <td class="py-4 px-5 text-center">
                  <a class="inline-block bg-orange-500 text-white font-bold text-xs px-4 py-2 rounded-lg hover:bg-orange-600 transition no-underline" href="{{ $detailUrl }}">Detail</a>
                </td>
              </tr>
              @empty
              <tr>
                <td class="py-8 px-5 text-center text-gray-400" colspan="6">Belum ada arsip yang sesuai.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-5 py-4 border-t border-gray-100">
          <div class="text-gray-500 text-sm">
            @if ($archives->total() > 0)
            Menampilkan {{ $archives->firstItem() }}-{{ $archives->lastItem() }} dari {{ $archives->total() }} arsip
            @else
            Belum ada hasil
            @endif
          </div>
          <div class="flex items-center gap-1">
            <a href="{{ $archives->previousPageUrl() ?? '#' }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-orange-50 hover:text-orange-500 hover:border-orange-200 transition {{ $archives->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }} no-underline">
              <i class="bi bi-chevron-left"></i>
            </a>
            <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-orange-500 text-white font-bold text-sm">{{ $archives->currentPage() }}</span>
            <a href="{{ $archives->nextPageUrl() ?? '#' }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-orange-50 hover:text-orange-500 hover:border-orange-200 transition {{ $archives->hasMorePages() ? '' : 'opacity-50 pointer-events-none' }} no-underline">
              <i class="bi bi-chevron-right"></i>
            </a>
          </div>
        </div>
      </section>

      @if ($canInputLetter)
      <section class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
        <div class="font-bold text-gray-900 mb-3">Aksi Cepat</div>
        <div class="flex flex-wrap gap-3">
          <a class="inline-flex items-center bg-orange-500 text-white font-bold py-2.5 px-5 rounded-xl hover:bg-orange-600 shadow-orange transition text-sm no-underline" href="{{ route('tambah-surat-masuk') }}">
            <i class="bi bi-inbox me-2"></i> Input Surat Masuk
          </a>
          <a class="inline-flex items-center bg-gray-700 text-white font-bold py-2.5 px-5 rounded-xl hover:bg-gray-800 transition text-sm no-underline" href="{{ route('tambah-surat-keluar') }}">
            <i class="bi bi-send me-2"></i> Buat Surat Keluar
          </a>
        </div>
      </section>
      @endif
    </main>
  </div>
</x-app-layout>