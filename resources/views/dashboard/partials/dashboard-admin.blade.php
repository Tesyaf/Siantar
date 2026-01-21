<!-- ADMIN Dashboard -->
<div class="min-h-screen bg-[#f5f7fb] text-gray-900">
    <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6 space-y-4">
        <!-- HERO -->
        <section class="rounded-2xl p-6 text-white shadow-[0_10px_30px_rgba(17,24,39,0.06)] bg-[linear-gradient(90deg,#dc2626_0%,#ef4444_55%,#f87171_100%)]">
            <h4 class="text-2xl font-extrabold tracking-tight">Dashboard Admin</h4>
            <p class="text-sm font-medium mt-1">Kelola sistem, pengguna, dan laporan keseluruhan</p>
            <p class="text-sm mt-3 font-semibold">{{ Auth::user()->name }}</p>
        </section>

        <!-- OVERVIEW CARDS -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
            <!-- Total Surat Masuk -->
            <div class="bg-white rounded-2xl p-5 border border-[#e6eaf2] shadow-[0_8px_20px_rgba(17,24,39,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Total Surat Masuk</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $incomingStats[0]['value'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-100 text-blue-600 grid place-items-center text-lg">
                        <i class="bi bi-inbox-fill"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-3">Dalam sistem</p>
            </div>

            <!-- Total Surat Keluar -->
            <div class="bg-white rounded-2xl p-5 border border-[#e6eaf2] shadow-[0_8px_20px_rgba(17,24,39,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Total Surat Keluar</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $outgoingStats[0]['value'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-green-100 text-green-600 grid place-items-center text-lg">
                        <i class="bi bi-send-fill"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-3">Dalam sistem</p>
            </div>

        </section>

        <!-- ADMIN ACTIONS -->
        <section>
            <h6 class="font-bold mb-3">Menu Admin</h6>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <a href="{{ route('surat-masuk.index') }}" class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex gap-3 text-gray-900 no-underline hover:border-blue-200 hover:bg-blue-100/70 transition">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 grid place-items-center text-lg flex-shrink-0">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <div>
                        <p class="font-extrabold text-sm">Surat Masuk</p>
                        <p class="text-xs text-gray-500 mt-1">Kelola masuk</p>
                    </div>
                </a>

                <a href="{{ route('surat-keluar.index') }}" class="bg-green-50 border border-green-100 rounded-2xl p-4 flex gap-3 text-gray-900 no-underline hover:border-green-200 hover:bg-green-100/70 transition">
                    <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 grid place-items-center text-lg flex-shrink-0">
                        <i class="bi bi-send"></i>
                    </div>
                    <div>
                        <p class="font-extrabold text-sm">Surat Keluar</p>
                        <p class="text-xs text-gray-500 mt-1">Kelola keluar</p>
                    </div>
                </a>

                <a href="{{ route('cari-arsip') }}" class="bg-purple-50 border border-purple-100 rounded-2xl p-4 flex gap-3 text-gray-900 no-underline hover:border-purple-200 hover:bg-purple-100/70 transition">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 grid place-items-center text-lg flex-shrink-0">
                        <i class="bi bi-archive"></i>
                    </div>
                    <div>
                        <p class="font-extrabold text-sm">Arsip</p>
                        <p class="text-xs text-gray-500 mt-1">Kelola arsip</p>
                    </div>
                </a>

                <a href="{{ route('admin.users.index') }}" class="bg-orange-50 border border-orange-100 rounded-2xl p-4 flex gap-3 text-gray-900 no-underline hover:border-orange-200 hover:bg-orange-100/70 transition">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 grid place-items-center text-lg flex-shrink-0">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <p class="font-extrabold text-sm">Kelola Pengguna</p>
                        <p class="text-xs text-gray-500 mt-1">Akun & akses</p>
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
                        <div class="text-[15px] font-extrabold">Ringkasan Surat Masuk</div>
                        <div class="text-xs text-gray-500 mt-1">Statistik keseluruhan</div>
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

                <a href="{{ route('surat-masuk.index') }}" class="mt-4 w-full rounded-xl bg-blue-500 text-white font-bold py-3 shadow-[0_10px_18px_rgba(59,130,246,0.22)] hover:bg-blue-600 text-center block">
                    Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="bg-white border border-[#e6eaf2] rounded-[14px] shadow-[0_8px_20px_rgba(17,24,39,0.05)] p-6">
                <div class="flex gap-3 items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 grid place-items-center text-lg">
                        <i class="bi bi-send-fill"></i>
                    </div>
                    <div>
                        <div class="text-[15px] font-extrabold">Ringkasan Surat Keluar</div>
                        <div class="text-xs text-gray-500 mt-1">Statistik keseluruhan</div>
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

                <a href="{{ route('surat-keluar.index') }}" class="mt-4 w-full rounded-xl bg-green-500 text-white font-bold py-3 shadow-[0_10px_18px_rgba(34,197,94,0.22)] hover:bg-green-600 text-center block">
                    Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </section>

        <!-- SYSTEM INFO -->
        <section class="bg-white rounded-[14px] border border-[#e6eaf2] shadow-[0_8px_20px_rgba(17,24,39,0.05)] p-6">
            <h3 class="font-bold text-lg mb-4">Informasi Sistem</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 border border-gray-100 rounded-lg">
                    <p class="text-xs text-gray-500 font-medium mb-1">Aplikasi</p>
                    <p class="text-lg font-bold text-gray-900">SIANTAR</p>
                </div>
                <div class="p-4 border border-gray-100 rounded-lg">
                    <p class="text-xs text-gray-500 font-medium mb-1">Versi</p>
                    <p class="text-lg font-bold text-gray-900">1.0.0</p>
                </div>
                <div class="p-4 border border-gray-100 rounded-lg">
                    <p class="text-xs text-gray-500 font-medium mb-1">Status</p>
                    <p class="text-lg font-bold text-green-600">Aktif</p>
                </div>
                <div class="p-4 border border-gray-100 rounded-lg">
                    <p class="text-xs text-gray-500 font-medium mb-1">Last Updated</p>
                    <p class="text-lg font-bold text-gray-900">{{ now()->format('d M Y') }}</p>
                </div>
            </div>
        </section>

        <!-- RECENT ACTIVITIES -->
        @if($activities->count() > 0)
        <section class="bg-white rounded-[14px] border border-[#e6eaf2] shadow-[0_8px_20px_rgba(17,24,39,0.05)] p-6">
            <h3 class="font-bold text-lg mb-4">Aktivitas Sistem</h3>
            <div class="space-y-3">
                @foreach($activities as $activity)
                <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                    <div class="w-10 h-10 rounded-lg {{ $activity['iconClass'] }} grid place-items-center flex-shrink-0">
                        <i class="bi {{ $activity['icon'] }}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $activity['time'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif
    </main>
</div>
