<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-white flex flex-col">
            @include('partials.header')

            <!-- Main Content -->
            <div class="flex-1 flex flex-col transition-all duration-300">
                
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="w-full py-6 flex justify-between items-center">
                            <div>{{ $header }}</div>
                            <div class="text-sm text-gray-500">
                                {{ Auth::user()->name }} ({{ Auth::user()->roleLabel() }})
                            </div>
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>

            @include('partials.footer')
        </div>
        @stack('scripts')
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


