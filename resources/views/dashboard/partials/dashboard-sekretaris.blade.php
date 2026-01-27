<!-- SEKRETARIS Dashboard -->
<div class="min-h-screen bg-[#f5f7fb] text-gray-900">
    <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6 space-y-4">
        <!-- HERO -->
        <section class="rounded-2xl p-6 text-white shadow-[0_10px_30px_rgba(17,24,39,0.06)] bg-[linear-gradient(90deg,#0891b2_0%,#06b6d4_55%,#22d3ee_100%)]">
            <h4 class="text-2xl font-extrabold tracking-tight">Dashboard Sekretaris</h4>
            <p class="text-sm font-medium mt-1">Kelola surat dan koordinasi dengan unit lain</p>
            <p class="text-sm mt-3 font-semibold">{{ Auth::user()->name }}</p>
        </section>

        <!-- OVERVIEW CARDS -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
            <!-- Total Surat Masuk -->
            <div class="bg-white rounded-2xl p-5 border border-[#e6eaf2] shadow-[0_8px_20px_rgba(17,24,39,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Total Masuk</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $incomingStats[0]['value'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-100 text-blue-600 grid place-items-center text-lg">
                        <i class="bi bi-inbox-fill"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-3">Tahun ini</p>
            </div>

            <!-- Total Surat Keluar -->
            <div class="bg-white rounded-2xl p-5 border border-[#e6eaf2] shadow-[0_8px_20px_rgba(17,24,39,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Total Keluar</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $outgoingStats[0]['value'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-green-100 text-green-600 grid place-items-center text-lg">
                        <i class="bi bi-send-fill"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-3">Tahun ini</p>
            </div>
        </section>

        <!-- QUICK ACTIONS -->
        <section>
            <h6 class="font-bold mb-3">Aksi Cepat</h6>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <a href="{{ route('tambah-surat-masuk') }}" class="bg-cyan-50 border border-cyan-100 rounded-2xl p-4 flex gap-3 text-gray-900 no-underline hover:border-cyan-200 hover:bg-cyan-100/70 transition">
                    <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-600 grid place-items-center text-lg flex-shrink-0">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <div>
                        <p class="font-extrabold text-sm">Input Surat Masuk</p>
                        <p class="text-xs text-gray-500 mt-1">Catat surat baru</p>
                    </div>
                </a>

                <a href="{{ route('surat-keluar.index') }}" class="bg-yellow-50 border border-yellow-100 rounded-2xl p-4 flex gap-3 text-gray-900 no-underline hover:border-yellow-200 hover:bg-yellow-100/70 transition">
                    <div class="w-10 h-10 rounded-xl bg-yellow-100 text-yellow-600 grid place-items-center text-lg flex-shrink-0">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                    <div>
                        <p class="font-extrabold text-sm">Lihat Surat Keluar</p>
                        <p class="text-xs text-gray-500 mt-1">Pantau pengiriman</p>
                    </div>
                </a>

                <a href="{{ route('cari-arsip') }}" class="bg-teal-50 border border-teal-100 rounded-2xl p-4 flex gap-3 text-gray-900 no-underline hover:border-teal-200 hover:bg-teal-100/70 transition">
                    <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-600 grid place-items-center text-lg flex-shrink-0">
                        <i class="bi bi-search"></i>
                    </div>
                    <div>
                        <p class="font-extrabold text-sm">Arsip Digital</p>
                        <p class="text-xs text-gray-500 mt-1">Cari surat lama</p>
                    </div>
                </a>
            </div>
        </section>

        <!-- SUMMARY CARDS -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white border border-[#e6eaf2] rounded-[14px] shadow-[0_8px_20px_rgba(17,24,39,0.05)] p-6">
                <div class="flex gap-3 items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 grid place-items-center text-lg">
                        <i class="bi bi-inbox-fill"></i>
                    </div>
                    <div>
                        <div class="text-[15px] font-extrabold">Detail Surat Masuk</div>
                        <div class="text-xs text-gray-500 mt-1">Informasi lengkap surat masuk</div>
                    </div>
                </div>

                @foreach ($incomingStats as $stat)
                <div class="mt-2 flex items-center justify-between rounded-xl px-3 py-2 text-sm {{ $stat['rowClass'] }}">
                    <div class="flex items-center gap-2 font-medium text-gray-700">
                        <span class="text-base {{ $stat['iconClass'] }}"><i class="bi {{ $stat['icon'] }}"></i></span>
                        <span>{{ $stat['label'] }}</span>
                    </div>
                    <strong class="{{ $stat['valueClass'] }}">{{ $stat['value'] }}</strong>
                </div>
                @endforeach

                <a href="{{ route('surat-masuk.index') }}" class="mt-4 w-full rounded-xl bg-cyan-500 text-white font-bold py-2 hover:bg-cyan-600 text-center text-sm block no-underline">
                    Lihat Semua
                </a>
            </div>

            <div class="bg-white border border-[#e6eaf2] rounded-[14px] shadow-[0_8px_20px_rgba(17,24,39,0.05)] p-6">
                <div class="flex gap-3 items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 grid place-items-center text-lg">
                        <i class="bi bi-send-fill"></i>
                    </div>
                    <div>
                        <div class="text-[15px] font-extrabold">Detail Surat Keluar</div>
                        <div class="text-xs text-gray-500 mt-1">Informasi lengkap surat keluar</div>
                    </div>
                </div>

                @foreach ($outgoingStats as $stat)
                <div class="mt-2 flex items-center justify-between rounded-xl px-3 py-2 text-sm {{ $stat['rowClass'] }}">
                    <div class="flex items-center gap-2 font-medium text-gray-700">
                        <span class="text-base {{ $stat['iconClass'] }} {{ !empty($stat['rotate']) ? '-rotate-180' : '' }}">
                            <i class="bi {{ $stat['icon'] }}"></i>
                        </span>
                        <span>{{ $stat['label'] }}</span>
                    </div>
                    <strong class="{{ $stat['valueClass'] }}">{{ $stat['value'] }}</strong>
                </div>
                @endforeach

                <a href="{{ route('surat-keluar.index') }}" class="mt-4 w-full rounded-xl bg-cyan-500 text-white font-bold py-2 hover:bg-cyan-600 text-center text-sm block no-underline">
                    Lihat Semua
                </a>
            </div>
        </section>

        <!-- RECENT LETTERS -->
        @if($latestLetters->count() > 0)
        <section class="bg-white rounded-[14px] border border-[#e6eaf2] shadow-[0_8px_20px_rgba(17,24,39,0.05)] p-6">
            <h3 class="font-bold text-lg mb-4">Surat Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm table-fixed" data-sortable>
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 px-3 font-bold text-gray-700" data-sortable-col>
                                <button type="button" class="inline-flex items-center gap-2" data-sort-button>
                                    No. Surat <span class="text-xs text-gray-400" data-sort-indicator>↕</span>
                                </button>
                            </th>
                            <th class="text-left py-3 px-3 font-bold text-gray-700" data-sortable-col data-sort-type="date">
                                <button type="button" class="inline-flex items-center gap-2" data-sort-button>
                                    Tanggal <span class="text-xs text-gray-400" data-sort-indicator>↕</span>
                                </button>
                            </th>
                            <th class="text-left py-3 px-3 font-bold text-gray-700" data-sortable-col>
                                <button type="button" class="inline-flex items-center gap-2" data-sort-button>
                                    Perihal <span class="text-xs text-gray-400" data-sort-indicator>↕</span>
                                </button>
                            </th>
                            <th class="text-left py-3 px-3 font-bold text-gray-700" data-sortable-col>
                                <button type="button" class="inline-flex items-center gap-2" data-sort-button>
                                    Tipe <span class="text-xs text-gray-400" data-sort-indicator>↕</span>
                                </button>
                            </th>
                            <th class="text-center py-3 px-3 font-bold text-gray-400 w-16"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestLetters as $letter)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="py-3 px-3 font-medium">{{ $letter['no'] }}</td>
                            <td class="py-3 px-3 text-gray-600" data-sort-value="{{ $letter['date_sort'] ? \Carbon\Carbon::parse($letter['date_sort'])->format('Y-m-d') : '' }}">{{ $letter['date'] }}</td>
                            <td class="py-3 px-3 text-gray-700">{{ Str::limit($letter['subject'], 30) }}</td>
                            <td class="py-3 px-3"><span class="text-xs px-2 py-1 rounded-full {{ $letter['typeClass'] }}">{{ $letter['type'] }}</span></td>
                            <td class="py-3 px-3 text-center w-16">
                                <div x-data="{ open: false }" class="relative inline-block action-menu">
                                    <button @click="open = !open" @click.outside="open = false" class="w-8 h-8 inline-flex items-center justify-center rounded-lg hover:bg-gray-100 transition text-gray-500">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-1 w-44 bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden">
                                        <a href="{{ $letter['link'] }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-cyan-50 hover:text-cyan-700 no-underline">
                                            <i class="bi bi-eye"></i> Lihat Detail
                                        </a>
                                        @if (auth()->user()->hasAnyRole(['sekretariat', 'admin']))
                                        <a href="{{ $letter['type'] === 'Masuk' ? route('surat-masuk.edit', $letter['id']) : route('surat-keluar.edit', $letter['id']) }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-cyan-50 hover:text-cyan-700 no-underline">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        @endif
    </main>
</div>
