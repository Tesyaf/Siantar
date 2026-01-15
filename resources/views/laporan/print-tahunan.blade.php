<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tahunan - {{ $year }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            background: white;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 14px;
            font-weight: normal;
        }

        .header p {
            font-size: 11px;
            color: #666;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-box {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .stat-box .label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }

        .stat-box .value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .stat-box .diff {
            font-size: 10px;
        }

        .diff.positive {
            color: green;
        }

        .diff.negative {
            color: red;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f5f5f5;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }

        .footer .date {
            margin-bottom: 60px;
        }

        .footer .signature {
            font-weight: bold;
        }

        .total-row {
            background: #f5f5f5;
            font-weight: bold;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #f97316; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Cetak Laporan
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #6b7280; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            Tutup
        </button>
    </div>

    <div class="header">
        <h1>LAPORAN SURAT MENYURAT</h1>
        <h2>Tahun {{ $year }}</h2>
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Ringkasan Statistik Tahunan</div>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="label">Surat Masuk</div>
                <div class="value">{{ $incomingStats['total'] }}</div>
                @if ($comparison['incomingDiff'] != 0)
                <div class="diff {{ $comparison['incomingDiff'] > 0 ? 'positive' : 'negative' }}">
                    {{ $comparison['incomingDiff'] > 0 ? '+' : '' }}{{ $comparison['incomingDiff'] }}% dari tahun lalu
                </div>
                @endif
            </div>
            <div class="stat-box">
                <div class="label">Surat Keluar</div>
                <div class="value">{{ $outgoingStats['total'] }}</div>
                @if ($comparison['outgoingDiff'] != 0)
                <div class="diff {{ $comparison['outgoingDiff'] > 0 ? 'positive' : 'negative' }}">
                    {{ $comparison['outgoingDiff'] > 0 ? '+' : '' }}{{ $comparison['outgoingDiff'] }}% dari tahun lalu
                </div>
                @endif
            </div>
            <div class="stat-box">
                <div class="label">Total Surat</div>
                <div class="value">{{ $incomingStats['total'] + $outgoingStats['total'] }}</div>
            </div>
            <div class="stat-box">
                <div class="label">Selesai</div>
                <div class="value">{{ $incomingStats['selesai'] + $outgoingStats['selesai'] }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Ringkasan per Bulan</div>
        <table>
            <tr>
                <th>Bulan</th>
                <th class="text-center">Surat Masuk</th>
                <th class="text-center">Surat Keluar</th>
                <th class="text-center">Total</th>
            </tr>
            @php
            $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            @endphp
            @for ($i = 1; $i <= 12; $i++)
                <tr>
                <td>{{ $months[$i - 1] }}</td>
                <td class="text-center">{{ $incomingByMonth[$i] ?? 0 }}</td>
                <td class="text-center">{{ $outgoingByMonth[$i] ?? 0 }}</td>
                <td class="text-center">{{ ($incomingByMonth[$i] ?? 0) + ($outgoingByMonth[$i] ?? 0) }}</td>
                </tr>
                @endfor
                <tr class="total-row">
                    <td>Total</td>
                    <td class="text-center">{{ $incomingStats['total'] }}</td>
                    <td class="text-center">{{ $outgoingStats['total'] }}</td>
                    <td class="text-center">{{ $incomingStats['total'] + $outgoingStats['total'] }}</td>
                </tr>
        </table>
    </div>

    <div class="two-columns">
        <div class="section">
            <div class="section-title">Status Surat Masuk</div>
            <table>
                <tr>
                    <th>Status</th>
                    <th class="text-center">Jumlah</th>
                </tr>
                <tr>
                    <td>Baru</td>
                    <td class="text-center">{{ $incomingStats['baru'] }}</td>
                </tr>
                <tr>
                    <td>Menunggu</td>
                    <td class="text-center">{{ $incomingStats['menunggu'] }}</td>
                </tr>
                <tr>
                    <td>Diproses</td>
                    <td class="text-center">{{ $incomingStats['diproses'] }}</td>
                </tr>
                <tr>
                    <td>Selesai</td>
                    <td class="text-center">{{ $incomingStats['selesai'] }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total</td>
                    <td class="text-center">{{ $incomingStats['total'] }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Status Surat Keluar</div>
            <table>
                <tr>
                    <th>Status</th>
                    <th class="text-center">Jumlah</th>
                </tr>
                <tr>
                    <td>Menunggu</td>
                    <td class="text-center">{{ $outgoingStats['menunggu'] }}</td>
                </tr>
                <tr>
                    <td>Diproses</td>
                    <td class="text-center">{{ $outgoingStats['diproses'] }}</td>
                </tr>
                <tr>
                    <td>Terkirim</td>
                    <td class="text-center">{{ $outgoingStats['terkirim'] }}</td>
                </tr>
                <tr>
                    <td>Selesai</td>
                    <td class="text-center">{{ $outgoingStats['selesai'] }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total</td>
                    <td class="text-center">{{ $outgoingStats['total'] }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="two-columns">
        <div class="section">
            <div class="section-title">Kategori Surat Masuk</div>
            <table>
                <tr>
                    <th>Kategori</th>
                    <th class="text-center">Jumlah</th>
                </tr>
                @forelse ($incomingByCategory as $category => $count)
                <tr>
                    <td>{{ $category ?? 'Tidak berkategori' }}</td>
                    <td class="text-center">{{ $count }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </table>
        </div>

        <div class="section">
            <div class="section-title">Kategori Surat Keluar</div>
            <table>
                <tr>
                    <th>Kategori</th>
                    <th class="text-center">Jumlah</th>
                </tr>
                @forelse ($outgoingByCategory as $category => $count)
                <tr>
                    <td>{{ $category ?? 'Tidak berkategori' }}</td>
                    <td class="text-center">{{ $count }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Perbandingan dengan Tahun Sebelumnya ({{ $year - 1 }})</div>
        <table>
            <tr>
                <th>Jenis Surat</th>
                <th class="text-center">{{ $year - 1 }}</th>
                <th class="text-center">{{ $year }}</th>
                <th class="text-center">Perubahan</th>
            </tr>
            <tr>
                <td>Surat Masuk</td>
                <td class="text-center">{{ $comparison['lastYearIncoming'] }}</td>
                <td class="text-center">{{ $incomingStats['total'] }}</td>
                <td class="text-center">
                    @if ($comparison['incomingDiff'] != 0)
                    <span class="{{ $comparison['incomingDiff'] > 0 ? 'positive' : 'negative' }}">
                        {{ $comparison['incomingDiff'] > 0 ? '+' : '' }}{{ $comparison['incomingDiff'] }}%
                    </span>
                    @else
                    -
                    @endif
                </td>
            </tr>
            <tr>
                <td>Surat Keluar</td>
                <td class="text-center">{{ $comparison['lastYearOutgoing'] }}</td>
                <td class="text-center">{{ $outgoingStats['total'] }}</td>
                <td class="text-center">
                    @if ($comparison['outgoingDiff'] != 0)
                    <span class="{{ $comparison['outgoingDiff'] > 0 ? 'positive' : 'negative' }}">
                        {{ $comparison['outgoingDiff'] > 0 ? '+' : '' }}{{ $comparison['outgoingDiff'] }}%
                    </span>
                    @else
                    -
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <div class="date">Pematangsiantar, {{ now()->format('d F Y') }}</div>
        <div class="signature">
            <p>Mengetahui,</p>
            <br><br><br>
            <p>(_______________________)</p>
        </div>
    </div>
</body>

</html>