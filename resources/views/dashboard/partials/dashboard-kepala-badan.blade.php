<!-- KEPALA BADAN Dashboard -->
<div class="min-h-screen bg-[#f5f7fb] text-gray-900">
    <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6 space-y-4">
        <!-- HERO -->
        <section class="rounded-2xl p-6 text-white shadow-[0_10px_30px_rgba(17,24,39,0.06)] bg-[linear-gradient(90deg,#7c3aed_0%,#8b5cf6_55%,#a78bfa_100%)]">
            <h4 class="text-2xl font-extrabold tracking-tight">Dashboard Kepala Badan</h4>
            <p class="text-sm font-medium mt-1">Lihat ringkasan surat dan persetujuan yang menunggu</p>
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
                <p class="text-xs text-gray-400 mt-3">Semua surat yang diterima</p>
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
                <p class="text-xs text-gray-400 mt-3">Semua surat yang dikirim</p>
            </div>
        </section>

        <!-- ACTIONS -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <a href="{{ route('surat-masuk.index') }}" class="bg-white rounded-2xl p-6 border border-[#e6eaf2] shadow-[0_8px_20px_rgba(17,24,39,0.05)] text-gray-900 no-underline hover:border-purple-300 hover:shadow-[0_8px_20px_rgba(124,58,237,0.1)] transition">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 grid place-items-center">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h3 class="font-bold">Lihat Surat Masuk</h3>
                </div>
                <p class="text-xs text-gray-500">Kelola dan berikan persetujuan surat masuk</p>
            </a>

            <a href="{{ route('surat-keluar.index') }}" class="bg-white rounded-2xl p-6 border border-[#e6eaf2] shadow-[0_8px_20px_rgba(17,24,39,0.05)] text-gray-900 no-underline hover:border-purple-300 hover:shadow-[0_8px_20px_rgba(124,58,237,0.1)] transition">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 text-green-600 grid place-items-center">
                        <i class="bi bi-send"></i>
                    </div>
                    <h3 class="font-bold">Lihat Surat Keluar</h3>
                </div>
                <p class="text-xs text-gray-500">Pantau dan persetujui surat keluar</p>
            </a>

            <a href="{{ route('cari-arsip') }}" class="bg-white rounded-2xl p-6 border border-[#e6eaf2] shadow-[0_8px_20px_rgba(17,24,39,0.05)] text-gray-900 no-underline hover:border-purple-300 hover:shadow-[0_8px_20px_rgba(124,58,237,0.1)] transition">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-600 grid place-items-center">
                        <i class="bi bi-archive"></i>
                    </div>
                    <h3 class="font-bold">Arsip Digital</h3>
                </div>
                <p class="text-xs text-gray-500">Cari dan kelola arsip surat</p>
            </a>
        </section>

        <!-- RECENT ACTIVITIES -->
        @if($activities->count() > 0)
        <section class="bg-white rounded-[14px] border border-[#e6eaf2] shadow-[0_8px_20px_rgba(17,24,39,0.05)] p-6">
            <h3 class="font-bold text-lg mb-4">Aktivitas Terbaru</h3>
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
