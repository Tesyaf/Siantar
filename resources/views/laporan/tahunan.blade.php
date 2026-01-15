<x-app-layout>
    <div class="min-h-screen bg-[#f5f7fb]">
        <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6">
            <a href="{{ route('laporan.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-orange-500 font-semibold text-sm no-underline transition-colors">
                <i class="bi bi-arrow-left"></i> Kembali ke Laporan
            </a>

            <div class="flex items-center justify-between mt-4 mb-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Laporan Tahunan</h1>
                    <p class="text-gray-500 text-sm">Tahun {{ $year }}</p>
                </div>
                <div class="flex gap-2">
                    <form action="{{ route('laporan.tahunan') }}" method="GET" class="flex items-center gap-2">
                        <select name="year" class="px-4 py-2 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition">
                            @for ($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-xl text-sm font-bold hover:bg-orange-600 transition">
                            <i class="bi bi-arrow-repeat"></i>
                        </button>
                    </form>
                    <a href="{{ route('laporan.preview-pdf', ['type' => 'yearly', 'year' => $year]) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-xl text-sm font-bold hover:bg-blue-600 transition no-underline">
                        <i class="bi bi-file-earmark-pdf me-2"></i> Gabung PDF
                    </a>
                    <a href="{{ route('laporan.print', ['type' => 'yearly', 'year' => $year]) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition no-underline">
                        <i class="bi bi-printer me-2"></i> Cetak
                    </a>
                </div>
            </div>

            <!-- Statistik Utama -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wide">Surat Masuk</div>
                    <div class="text-3xl font-extrabold text-orange-500 mt-1">{{ $incomingStats['total'] }}</div>
                    @if ($comparison['incomingDiff'] != 0)
                    <div class="text-xs {{ $comparison['incomingDiff'] > 0 ? 'text-green-500' : 'text-red-500' }} mt-1">
                        <i class="bi bi-{{ $comparison['incomingDiff'] > 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                        {{ abs($comparison['incomingDiff']) }}% dari tahun lalu
                    </div>
                    @endif
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wide">Surat Keluar</div>
                    <div class="text-3xl font-extrabold text-blue-500 mt-1">{{ $outgoingStats['total'] }}</div>
                    @if ($comparison['outgoingDiff'] != 0)
                    <div class="text-xs {{ $comparison['outgoingDiff'] > 0 ? 'text-green-500' : 'text-red-500' }} mt-1">
                        <i class="bi bi-{{ $comparison['outgoingDiff'] > 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                        {{ abs($comparison['outgoingDiff']) }}% dari tahun lalu
                    </div>
                    @endif
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

            <!-- Grafik per Bulan -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4">Grafik Surat per Bulan</h3>
                <div class="h-72">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Status Surat Masuk -->
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Status Surat Masuk</h3>
                    <div class="h-48">
                        <canvas id="incomingStatusChart"></canvas>
                    </div>
                </div>

                <!-- Status Surat Keluar -->
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Status Surat Keluar</h3>
                    <div class="h-48">
                        <canvas id="outgoingStatusChart"></canvas>
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

            <!-- Tabel Ringkasan Bulanan -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4">Ringkasan per Bulan</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b border-gray-200">
                            <tr>
                                <th class="text-left py-3 px-4 font-bold text-gray-600">Bulan</th>
                                <th class="text-center py-3 px-4 font-bold text-gray-600">Surat Masuk</th>
                                <th class="text-center py-3 px-4 font-bold text-gray-600">Surat Keluar</th>
                                <th class="text-center py-3 px-4 font-bold text-gray-600">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            @endphp
                            @for ($i = 1; $i <= 12; $i++)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-4 text-gray-900">{{ $months[$i - 1] }}</td>
                                <td class="py-3 px-4 text-center text-orange-600 font-semibold">{{ $incomingByMonth[$i] ?? 0 }}</td>
                                <td class="py-3 px-4 text-center text-blue-600 font-semibold">{{ $outgoingByMonth[$i] ?? 0 }}</td>
                                <td class="py-3 px-4 text-center text-gray-900 font-bold">{{ ($incomingByMonth[$i] ?? 0) + ($outgoingByMonth[$i] ?? 0) }}</td>
                                </tr>
                                @endfor
                                <tr class="bg-gray-50 font-bold">
                                    <td class="py-3 px-4 text-gray-900">Total</td>
                                    <td class="py-3 px-4 text-center text-orange-600">{{ $incomingStats['total'] }}</td>
                                    <td class="py-3 px-4 text-center text-blue-600">{{ $outgoingStats['total'] }}</td>
                                    <td class="py-3 px-4 text-center text-gray-900">{{ $incomingStats['total'] + $outgoingStats['total'] }}</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        const incomingByMonth = @json($incomingByMonth);
        const outgoingByMonth = @json($outgoingByMonth);

        const incomingValues = monthLabels.map((_, i) => incomingByMonth[i + 1] || 0);
        const outgoingValues = monthLabels.map((_, i) => outgoingByMonth[i + 1] || 0);

        // Monthly Chart
        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                        label: 'Surat Masuk',
                        data: incomingValues,
                        backgroundColor: '#f97316',
                        borderRadius: 4,
                    },
                    {
                        label: 'Surat Keluar',
                        data: outgoingValues,
                        backgroundColor: '#3b82f6',
                        borderRadius: 4,
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

        // Incoming Status Pie Chart
        new Chart(document.getElementById('incomingStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Baru', 'Menunggu', 'Diproses', 'Selesai'],
                datasets: [{
                    data: [{
                            {
                                $incomingStats['baru']
                            }
                        },
                        {
                            {
                                $incomingStats['menunggu']
                            }
                        },
                        {
                            {
                                $incomingStats['diproses']
                            }
                        },
                        {
                            {
                                $incomingStats['selesai']
                            }
                        }
                    ],
                    backgroundColor: ['#3b82f6', '#f59e0b', '#f97316', '#22c55e'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Outgoing Status Pie Chart
        new Chart(document.getElementById('outgoingStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Diproses', 'Terkirim', 'Selesai'],
                datasets: [{
                    data: [{
                            {
                                $outgoingStats['menunggu']
                            }
                        },
                        {
                            {
                                $outgoingStats['diproses']
                            }
                        },
                        {
                            {
                                $outgoingStats['terkirim']
                            }
                        },
                        {
                            {
                                $outgoingStats['selesai']
                            }
                        }
                    ],
                    backgroundColor: ['#f59e0b', '#f97316', '#3b82f6', '#22c55e'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>