<x-app-layout>
    <div class="min-h-screen bg-[#f5f7fb]">
        <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-orange-500 font-semibold text-sm no-underline transition-colors">
                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>

            <h1 class="mt-4 mb-1 text-2xl font-extrabold text-gray-900">Laporan Surat</h1>
            <p class="text-gray-500 text-sm mb-6">Generate laporan bulanan dan tahunan surat masuk & keluar</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Laporan Bulanan -->
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center">
                            <i class="bi bi-calendar-month text-orange-500 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-lg text-gray-900">Laporan Bulanan</h2>
                            <p class="text-gray-500 text-sm">Statistik surat per bulan</p>
                        </div>
                    </div>

                    <form action="{{ route('laporan.bulanan') }}" method="GET">
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700 mb-2">Pilih Bulan</label>
                            <input type="month" name="month" value="{{ now()->format('Y-m') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" />
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-orange-500 text-white rounded-xl text-sm font-bold hover:bg-orange-600 shadow-orange transition">
                            <i class="bi bi-file-earmark-bar-graph me-2"></i> Generate Laporan Bulanan
                        </button>
                    </form>
                </div>

                <!-- Laporan Tahunan -->
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                            <i class="bi bi-calendar-check text-blue-500 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-lg text-gray-900">Laporan Tahunan</h2>
                            <p class="text-gray-500 text-sm">Statistik surat per tahun</p>
                        </div>
                    </div>

                    <form action="{{ route('laporan.tahunan') }}" method="GET">
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700 mb-2">Pilih Tahun</label>
                            <select name="year" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition appearance-none bg-white">
                                @foreach ($years as $year)
                                <option value="{{ $year }}" @selected($year===now()->year)>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-500 text-white rounded-xl text-sm font-bold hover:bg-blue-600 transition">
                            <i class="bi bi-file-earmark-bar-graph me-2"></i> Generate Laporan Tahunan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Info -->
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3 mt-6">
                <i class="bi bi-info-circle-fill text-blue-500 mt-0.5"></i>
                <div class="text-sm text-blue-800">
                    <strong>Informasi:</strong> Laporan akan menampilkan statistik lengkap termasuk jumlah surat masuk & keluar, kategori, dan grafik visualisasi data.
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
