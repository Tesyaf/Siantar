<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan - {{ $monthName }}</title>
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
        <h2>Periode: {{ $monthName }}</h2>
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Ringkasan Statistik</div>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="label">Surat Masuk</div>
                <div class="value">{{ $incomingStats['total'] }}</div>
            </div>
            <div class="stat-box">
                <div class="label">Surat Keluar</div>
                <div class="value">{{ $outgoingStats['total'] }}</div>
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

    <div class="two-columns">
        <div class="section">
            <div class="section-title">Status Surat Masuk</div>
            <table>
                <tr>
                    <th>Status</th>
                    <th>Jumlah</th>
                </tr>
                <tr>
                    <td>Baru</td>
                    <td>{{ $incomingStats['baru'] }}</td>
                </tr>
                <tr>
                    <td>Menunggu</td>
                    <td>{{ $incomingStats['menunggu'] }}</td>
                </tr>
                <tr>
                    <td>Diproses</td>
                    <td>{{ $incomingStats['diproses'] }}</td>
                </tr>
                <tr>
                    <td>Selesai</td>
                    <td>{{ $incomingStats['selesai'] }}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <th>{{ $incomingStats['total'] }}</th>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Status Surat Keluar</div>
            <table>
                <tr>
                    <th>Status</th>
                    <th>Jumlah</th>
                </tr>
                <tr>
                    <td>Menunggu</td>
                    <td>{{ $outgoingStats['menunggu'] }}</td>
                </tr>
                <tr>
                    <td>Diproses</td>
                    <td>{{ $outgoingStats['diproses'] }}</td>
                </tr>
                <tr>
                    <td>Terkirim</td>
                    <td>{{ $outgoingStats['terkirim'] }}</td>
                </tr>
                <tr>
                    <td>Selesai</td>
                    <td>{{ $outgoingStats['selesai'] }}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <th>{{ $outgoingStats['total'] }}</th>
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
                    <th>Jumlah</th>
                </tr>
                @forelse ($incomingByCategory as $category => $count)
                <tr>
                    <td>{{ $category ?? 'Tidak berkategori' }}</td>
                    <td>{{ $count }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" style="text-align: center;">Tidak ada data</td>
                </tr>
                @endforelse
            </table>
        </div>

        <div class="section">
            <div class="section-title">Kategori Surat Keluar</div>
            <table>
                <tr>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                </tr>
                @forelse ($outgoingByCategory as $category => $count)
                <tr>
                    <td>{{ $category ?? 'Tidak berkategori' }}</td>
                    <td>{{ $count }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" style="text-align: center;">Tidak ada data</td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Daftar Surat Masuk</div>
        <table>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Perihal</th>
                <th>Pengirim</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
            @forelse ($allIncoming as $index => $letter)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $letter->letter_number }}</td>
                <td>{{ Str::limit($letter->subject, 30) }}</td>
                <td>{{ $letter->sender }}</td>
                <td>{{ $letter->received_date->format('d/m/Y') }}</td>
                <td>{{ ucfirst($letter->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data surat masuk</td>
            </tr>
            @endforelse
        </table>
    </div>

    <div class="section">
        <div class="section-title">Daftar Surat Keluar</div>
        <table>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Perihal</th>
                <th>Tujuan</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
            @forelse ($allOutgoing as $index => $letter)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $letter->letter_number }}</td>
                <td>{{ Str::limit($letter->subject, 30) }}</td>
                <td>{{ $letter->recipient }}</td>
                <td>{{ $letter->letter_date->format('d/m/Y') }}</td>
                <td>{{ ucfirst($letter->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data surat keluar</td>
            </tr>
            @endforelse
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