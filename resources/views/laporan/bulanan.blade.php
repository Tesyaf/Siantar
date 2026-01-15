<x-app-layout>
    <div class="min-h-screen bg-[#f5f7fb]">
        <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6">
            <a href="{{ route('laporan.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-orange-500 font-semibold text-sm no-underline transition-colors">
                <i class="bi bi-arrow-left"></i> Kembali ke Laporan
            </a>

            <div class="flex items-center justify-between mt-4 mb-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Laporan Bulanan</h1>
                    <p class="text-gray-500 text-sm">{{ $monthName }}</p>
                </div>
                <div class="flex gap-2">
                    <form action="{{ route('laporan.bulanan') }}" method="GET" class="flex items-center gap-2">
                        <input type="month" name="month" value="{{ $month }}" class="px-4 py-2 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" />
                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-xl text-sm font-bold hover:bg-orange-600 transition">
                            <i class="bi bi-arrow-repeat"></i>
                        </button>
                    </form>
                    <a href="{{ route('laporan.preview-pdf', ['type' => 'monthly', 'month' => $month]) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-xl text-sm font-bold hover:bg-blue-600 transition no-underline">
                        <i class="bi bi-file-earmark-pdf me-2"></i> Gabung PDF
                    </a>
                    <a href="{{ route('laporan.print', ['type' => 'monthly', 'month' => $month]) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition no-underline">
                        <i class="bi bi-printer me-2"></i> Cetak
                    </a>
                </div>
            </div>

            <!-- Statistik Utama -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wide">Surat Masuk</div>
                    <div class="text-3xl font-extrabold text-orange-500 mt-1">{{ $incomingStats['total'] }}</div>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wide">Surat Keluar</div>
                    <div class="text-3xl font-extrabold text-blue-500 mt-1">{{ $outgoingStats['total'] }}</div>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wide">Total Surat</div>
                    <div class="text-3xl font-extrabold text-gray-900 mt-1">{{ $incomingStats['total'] + $outgoingStats['total'] }}</div>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wide">Selesai Diproses</div>
                    <div class="text-3xl font-extrabold text-green-500 mt-1">{{ $incomingStats['selesai'] + $outgoingStats['selesai'] }}</div>
                </div>
            </div>

            <!-- Grafik per Hari -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4">Grafik Surat per Hari</h3>
                <div class="h-64">
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Status Surat Masuk -->
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Status Surat Masuk</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Baru</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">{{ $incomingStats['baru'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Menunggu</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">{{ $incomingStats['menunggu'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Diproses</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-orange-100 text-orange-700">{{ $incomingStats['diproses'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Selesai</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">{{ $incomingStats['selesai'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Status Surat Keluar -->
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Status Surat Keluar</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Menunggu</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">{{ $outgoingStats['menunggu'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Diproses</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-orange-100 text-orange-700">{{ $outgoingStats['diproses'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Terkirim</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">{{ $outgoingStats['terkirim'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Selesai</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">{{ $outgoingStats['selesai'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Kategori Surat Masuk -->
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Kategori Surat Masuk</h3>
                    @if (count($incomingByCategory) > 0)
                    <div class="space-y-3">
                        @foreach ($incomingByCategory as $category => $count)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ $category ?? 'Tidak berkategori' }}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500 text-sm">Tidak ada data kategori</p>
                    @endif
                </div>

                <!-- Kategori Surat Keluar -->
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Kategori Surat Keluar</h3>
                    @if (count($outgoingByCategory) > 0)
                    <div class="space-y-3">
                        @foreach ($outgoingByCategory as $category => $count)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ $category ?? 'Tidak berkategori' }}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500 text-sm">Tidak ada data kategori</p>
                    @endif
                </div>
            </div>

            <!-- Daftar Surat Terbaru -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Surat Masuk Terbaru -->
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Surat Masuk Terbaru</h3>
                    @if ($recentIncoming->count() > 0)
                    <div class="space-y-3">
                        @foreach ($recentIncoming as $letter)
                        <a href="{{ route('detail-surat-masuk', $letter) }}" class="block p-3 border border-gray-100 rounded-xl hover:bg-gray-50 transition no-underline">
                            <div class="font-bold text-sm text-gray-900">{{ $letter->letter_number }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($letter->subject, 40) }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ $letter->received_date->format('d M Y') }}</div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500 text-sm">Tidak ada surat masuk</p>
                    @endif
                </div>

                <!-- Surat Keluar Terbaru -->
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Surat Keluar Terbaru</h3>
                    @if ($recentOutgoing->count() > 0)
                    <div class="space-y-3">
                        @foreach ($recentOutgoing as $letter)
                        <a href="{{ route('detail-surat-keluar', $letter) }}" class="block p-3 border border-gray-100 rounded-xl hover:bg-gray-50 transition no-underline">
                            <div class="font-bold text-sm text-gray-900">{{ $letter->letter_number }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($letter->subject, 40) }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ $letter->letter_date->format('d M Y') }}</div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500 text-sm">Tidak ada surat keluar</p>
                    @endif
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const daysInMonth = {
            {
                $daysInMonth
            }
        };
        const labels = Array.from({
            length: daysInMonth
        }, (_, i) => i + 1);

        const incomingData = @json($incomingByDay);
        const outgoingData = @json($outgoingByDay);

        const incomingValues = labels.map(day => incomingData[day] || 0);
        const outgoingValues = labels.map(day => outgoingData[day] || 0);

        new Chart(document.getElementById('dailyChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Surat Masuk',
                        data: incomingValues,
                        borderColor: '#f97316',
                        backgroundColor: 'rgba(249, 115, 22, 0.1)',
                        fill: true,
                        tension: 0.3,
                    },
                    {
                        label: 'Surat Keluar',
                        data: outgoingValues,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.3,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>