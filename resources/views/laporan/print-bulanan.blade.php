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

        .sort-button {
            background: none;
            border: none;
            padding: 0;
            font: inherit;
            color: inherit;
            cursor: pointer;
        }

        .sort-indicator {
            color: #888;
            font-size: 10px;
            margin-left: 6px;
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
        </div>
    </div>

    <div class="two-columns">
        <div class="section">
            <div class="section-title">Kategori Surat Masuk</div>
            <table data-sortable>
                <tr>
                    <th data-sortable-col>
                        <button type="button" class="sort-button" data-sort-button>
                            Kategori <span class="sort-indicator" data-sort-indicator>↕</span>
                        </button>
                    </th>
                    <th data-sortable-col data-sort-type="number">
                        <button type="button" class="sort-button" data-sort-button>
                            Jumlah <span class="sort-indicator" data-sort-indicator>↕</span>
                        </button>
                    </th>
                </tr>
                @forelse ($incomingByCategory as $category => $count)
                <tr>
                    <td>{{ $category ?? 'Tidak berkategori' }}</td>
                    <td>{{ $count }}</td>
                </tr>
                @empty
                <tr data-no-sort="true">
                    <td colspan="2" style="text-align: center;">Tidak ada data</td>
                </tr>
                @endforelse
            </table>
        </div>

        <div class="section">
            <div class="section-title">Kategori Surat Keluar</div>
            <table data-sortable>
                <tr>
                    <th data-sortable-col>
                        <button type="button" class="sort-button" data-sort-button>
                            Kategori <span class="sort-indicator" data-sort-indicator>↕</span>
                        </button>
                    </th>
                    <th data-sortable-col data-sort-type="number">
                        <button type="button" class="sort-button" data-sort-button>
                            Jumlah <span class="sort-indicator" data-sort-indicator>↕</span>
                        </button>
                    </th>
                </tr>
                @forelse ($outgoingByCategory as $category => $count)
                <tr>
                    <td>{{ $category ?? 'Tidak berkategori' }}</td>
                    <td>{{ $count }}</td>
                </tr>
                @empty
                <tr data-no-sort="true">
                    <td colspan="2" style="text-align: center;">Tidak ada data</td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Daftar Surat Masuk</div>
        <table data-sortable>
            <tr>
                <th data-sortable-col data-sort-type="number">
                    <button type="button" class="sort-button" data-sort-button>
                        No <span class="sort-indicator" data-sort-indicator>↕</span>
                    </button>
                </th>
                <th data-sortable-col>
                    <button type="button" class="sort-button" data-sort-button>
                        Nomor Surat <span class="sort-indicator" data-sort-indicator>↕</span>
                    </button>
                </th>
                <th data-sortable-col>
                    <button type="button" class="sort-button" data-sort-button>
                        Perihal <span class="sort-indicator" data-sort-indicator>↕</span>
                    </button>
                </th>
                <th data-sortable-col>
                    <button type="button" class="sort-button" data-sort-button>
                        Pengirim <span class="sort-indicator" data-sort-indicator>↕</span>
                    </button>
                </th>
                <th data-sortable-col data-sort-type="date">
                    <button type="button" class="sort-button" data-sort-button>
                        Tanggal <span class="sort-indicator" data-sort-indicator>↕</span>
                    </button>
                </th>
            </tr>
            @forelse ($allIncoming as $index => $letter)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $letter->letter_number }}</td>
                <td>{{ Str::limit($letter->subject, 30) }}</td>
                <td>{{ $letter->sender }}</td>
                <td data-sort-value="{{ $letter->received_date->format('Y-m-d') }}">{{ $letter->received_date->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr data-no-sort="true">
                <td colspan="5" style="text-align: center;">Tidak ada data surat masuk</td>
            </tr>
            @endforelse
        </table>
    </div>

    <div class="section">
        <div class="section-title">Daftar Surat Keluar</div>
        <table data-sortable>
            <tr>
                <th data-sortable-col data-sort-type="number">
                    <button type="button" class="sort-button" data-sort-button>
                        No <span class="sort-indicator" data-sort-indicator>↕</span>
                    </button>
                </th>
                <th data-sortable-col>
                    <button type="button" class="sort-button" data-sort-button>
                        Nomor Surat <span class="sort-indicator" data-sort-indicator>↕</span>
                    </button>
                </th>
                <th data-sortable-col>
                    <button type="button" class="sort-button" data-sort-button>
                        Perihal <span class="sort-indicator" data-sort-indicator>↕</span>
                    </button>
                </th>
                <th data-sortable-col>
                    <button type="button" class="sort-button" data-sort-button>
                        Tujuan <span class="sort-indicator" data-sort-indicator>↕</span>
                    </button>
                </th>
                <th data-sortable-col data-sort-type="date">
                    <button type="button" class="sort-button" data-sort-button>
                        Tanggal <span class="sort-indicator" data-sort-indicator>↕</span>
                    </button>
                </th>
            </tr>
            @forelse ($allOutgoing as $index => $letter)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $letter->letter_number }}</td>
                <td>{{ Str::limit($letter->subject, 30) }}</td>
                <td>{{ $letter->recipient }}</td>
                <td data-sort-value="{{ $letter->letter_date->format('Y-m-d') }}">{{ $letter->letter_date->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr data-no-sort="true">
                <td colspan="5" style="text-align: center;">Tidak ada data surat keluar</td>
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
    <script>
        (() => {
            const monthMap = {
                jan: 0,
                januari: 0,
                feb: 1,
                februari: 1,
                mar: 2,
                maret: 2,
                apr: 3,
                april: 3,
                mei: 4,
                may: 4,
                jun: 5,
                juni: 5,
                jul: 6,
                juli: 6,
                agu: 7,
                ags: 7,
                agustus: 7,
                sep: 8,
                sept: 8,
                september: 8,
                okt: 9,
                oktober: 9,
                oct: 9,
                nov: 10,
                november: 10,
                des: 11,
                desember: 11,
                dec: 11,
            };

            const parseDateValue = (value) => {
                if (!value) {
                    return NaN;
                }
                const isoMatch = value.match(/^(\d{4})-(\d{2})-(\d{2})/);
                if (isoMatch) {
                    return new Date(`${isoMatch[1]}-${isoMatch[2]}-${isoMatch[3]}T00:00:00`).getTime();
                }
                const slashMatch = value.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
                if (slashMatch) {
                    const day = Number(slashMatch[1]);
                    const month = Number(slashMatch[2]) - 1;
                    const year = Number(slashMatch[3]);
                    return new Date(year, month, day).getTime();
                }
                const parts = value.trim().split(/\s+/);
                if (parts.length >= 3) {
                    const day = Number(parts[0]);
                    const monthKey = parts[1].toLowerCase();
                    const year = Number(parts[2]);
                    const month = monthMap[monthKey];
                    if (!Number.isNaN(day) && !Number.isNaN(year) && month !== undefined) {
                        return new Date(year, month, day).getTime();
                    }
                }
                return NaN;
            };

            const parseCellValue = (cell, type) => {
                const rawValue = cell.dataset.sortValue ?? cell.textContent.trim();
                if (type === 'number') {
                    const normalized = rawValue.replace(/[^\d.\-]/g, '');
                    const value = Number.parseFloat(normalized);
                    return Number.isNaN(value) ? null : value;
                }
                if (type === 'date') {
                    const value = parseDateValue(rawValue);
                    return Number.isNaN(value) ? null : value;
                }
                return rawValue.toLowerCase();
            };

            const sortTable = (table, columnIndex, direction, type) => {
                const tbody = table.tBodies[0];
                if (!tbody) {
                    return;
                }

                const rows = Array.from(tbody.rows);
                const sortableRows = [];
                const staticRows = [];

                rows.forEach((row) => {
                    if (row.dataset.noSort === 'true') {
                        staticRows.push(row);
                        return;
                    }
                    const onlyCell = row.cells.length === 1 && row.cells[0]?.colSpan > 1;
                    if (onlyCell) {
                        staticRows.push(row);
                        return;
                    }
                    sortableRows.push(row);
                });

                sortableRows.sort((a, b) => {
                    const aCell = a.cells[columnIndex];
                    const bCell = b.cells[columnIndex];
                    if (!aCell || !bCell) {
                        return 0;
                    }
                    const aVal = parseCellValue(aCell, type);
                    const bVal = parseCellValue(bCell, type);
                    const aNull = aVal === null || aVal === '';
                    const bNull = bVal === null || bVal === '';

                    if (aNull && bNull) {
                        return 0;
                    }
                    if (aNull) {
                        return 1;
                    }
                    if (bNull) {
                        return -1;
                    }
                    if (typeof aVal === 'number' && typeof bVal === 'number') {
                        return aVal - bVal;
                    }
                    return String(aVal).localeCompare(String(bVal), 'id', {
                        numeric: true,
                        sensitivity: 'base',
                    });
                });

                if (direction === 'desc') {
                    sortableRows.reverse();
                }

                tbody.innerHTML = '';
                sortableRows.forEach((row) => tbody.appendChild(row));
                staticRows.forEach((row) => tbody.appendChild(row));
            };

            document.querySelectorAll('table[data-sortable]').forEach((table) => {
                const headers = table.querySelectorAll('th[data-sortable-col]');
                headers.forEach((header) => {
                    const button = header.querySelector('[data-sort-button]') ?? header;
                    button.addEventListener('click', () => {
                        const currentDirection = header.dataset.sortDirection === 'asc' ? 'asc' : 'desc';
                        const nextDirection = currentDirection === 'asc' ? 'desc' : 'asc';
                        headers.forEach((th) => {
                            th.dataset.sortDirection = '';
                            th.setAttribute('aria-sort', 'none');
                            const indicator = th.querySelector('[data-sort-indicator]');
                            if (indicator) {
                                indicator.textContent = '↕';
                            }
                        });
                        header.dataset.sortDirection = nextDirection;
                        header.setAttribute('aria-sort', nextDirection === 'asc' ? 'ascending' : 'descending');

                        const indicator = header.querySelector('[data-sort-indicator]');
                        if (indicator) {
                            indicator.textContent = nextDirection === 'asc' ? '↑' : '↓';
                        }

                        const type = header.dataset.sortType || 'string';
                        sortTable(table, header.cellIndex, nextDirection, type);
                    });
                });
            });
        })();
    </script>
</body>

</html>
