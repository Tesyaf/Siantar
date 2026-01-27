<x-app-layout>
    <div class="min-h-screen bg-[#f5f7fb]">
        <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6">
            <a href="{{ $type === 'monthly' ? route('laporan.bulanan', ['month' => $month]) : route('laporan.tahunan', ['year' => $year]) }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-orange-500 font-semibold text-sm no-underline transition-colors">
                <i class="bi bi-arrow-left"></i> Kembali ke Laporan
            </a>

            <div class="flex items-center justify-between mt-4 mb-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Preview & Gabung PDF</h1>
                    <p class="text-gray-500 text-sm">{{ $periodName }} - {{ count($pdfList) }} file PDF</p>
                </div>
                <div class="flex gap-2">
                    @if(count($pdfList) > 0)
                    <button id="mergeBtn" onclick="mergePdfs()" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-xl text-sm font-bold hover:bg-blue-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="bi bi-file-earmark-pdf me-2"></i>
                        <span id="mergeBtnText">Gabung Semua PDF</span>
                    </button>
                    <button id="mergeSelectedBtn" onclick="mergeSelectedPdfs()" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-xl text-sm font-bold hover:bg-green-600 transition disabled:opacity-50" disabled>
                        <i class="bi bi-check2-square me-2"></i>
                        <span id="mergeSelectedBtnText">Gabung Terpilih (0)</span>
                    </button>
                    @endif
                </div>
            </div>

            @if(count($pdfList) === 0)
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-12 text-center">
                <i class="bi bi-file-earmark-x text-6xl text-gray-300"></i>
                <p class="text-gray-500 mt-4">Tidak ada file PDF yang ditemukan untuk periode ini.</p>
            </div>
            @else

            <!-- Progress Bar -->
            <div id="progressContainer" class="hidden bg-white border border-gray-100 rounded-2xl shadow-sm p-4 mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-bold text-gray-700">Menggabungkan PDF...</span>
                    <span id="progressText" class="text-sm text-gray-500">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div id="progressBar" class="bg-blue-500 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <!-- Select All -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 mb-4">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()" class="w-5 h-5 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                    <span class="font-bold text-gray-700">Pilih Semua</span>
                </label>
            </div>

            <!-- PDF List -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="pdfGrid">
                @foreach($pdfList as $index => $pdf)
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden pdf-item" data-index="{{ $index }}">
                    <div class="p-4 border-b border-gray-100">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" class="pdf-checkbox w-5 h-5 mt-1 rounded border-gray-300 text-orange-500 focus:ring-orange-500" data-index="{{ $index }}" onchange="updateSelectedCount()">
                            <div class="flex-1 min-w-0">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold {{ $pdf['type'] === 'Surat Masuk' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $pdf['type'] }}
                                </span>
                                <p class="font-bold text-gray-900 text-sm mt-1 truncate">{{ $pdf['letter_number'] }}</p>
                                <p class="text-gray-500 text-xs truncate">{{ $pdf['subject'] }}</p>
                                <p class="text-gray-400 text-xs mt-1">{{ $pdf['date'] }}</p>
                            </div>
                        </label>
                    </div>
                    <div class="aspect-[4/3] bg-gray-100 relative">
                        <iframe src="{{ $pdf['preview_url'] }}" class="w-full h-full border-0"></iframe>
                        <a href="{{ $pdf['preview_url'] }}" target="_blank" class="absolute bottom-2 right-2 inline-flex items-center px-3 py-1.5 bg-white/90 text-gray-700 rounded-lg text-xs font-bold hover:bg-white transition shadow-sm no-underline">
                            <i class="bi bi-arrows-fullscreen me-1"></i> Fullscreen
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </main>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
    <script>
        const pdfList = @json($pdfList);
        let selectedIndices = [];

        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.pdf-checkbox');

            checkboxes.forEach(cb => {
                cb.checked = selectAll.checked;
            });

            updateSelectedCount();
        }

        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('.pdf-checkbox:checked');
            const count = checkboxes.length;
            const btn = document.getElementById('mergeSelectedBtn');
            const btnText = document.getElementById('mergeSelectedBtnText');

            selectedIndices = Array.from(checkboxes).map(cb => parseInt(cb.dataset.index));

            btnText.textContent = `Gabung Terpilih (${count})`;
            btn.disabled = count < 2;

            // Update select all checkbox
            const allCheckboxes = document.querySelectorAll('.pdf-checkbox');
            document.getElementById('selectAll').checked = count === allCheckboxes.length && count > 0;
        }

        async function mergePdfs() {
            const allIndices = pdfList.map((_, i) => i);
            await doMerge(allIndices, 'Laporan_Surat_{{ $type === "monthly" ? $month : $year }}.pdf');
        }

        async function mergeSelectedPdfs() {
            if (selectedIndices.length < 2) {
                alert('Pilih minimal 2 file PDF untuk digabung.');
                return;
            }
            await doMerge(selectedIndices, 'Laporan_Surat_Terpilih.pdf');
        }

        async function doMerge(indices, filename) {
            const mergeBtn = document.getElementById('mergeBtn');
            const mergeSelectedBtn = document.getElementById('mergeSelectedBtn');
            const progressContainer = document.getElementById('progressContainer');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');

            // Disable buttons
            mergeBtn.disabled = true;
            mergeSelectedBtn.disabled = true;
            document.getElementById('mergeBtnText').textContent = 'Memproses...';

            // Show progress
            progressContainer.classList.remove('hidden');
            progressBar.style.width = '0%';
            progressText.textContent = '0%';

            try {
                const {
                    PDFDocument
                } = PDFLib;
                const mergedPdf = await PDFDocument.create();

                for (let i = 0; i < indices.length; i++) {
                    const pdf = pdfList[indices[i]];
                    const progress = Math.round(((i + 1) / indices.length) * 100);

                    progressText.textContent = `${progress}% - Memproses: ${pdf.letter_number}`;
                    progressBar.style.width = `${progress}%`;

                    try {
                        const response = await fetch(pdf.url);
                        const pdfBytes = await response.arrayBuffer();
                        const pdfDoc = await PDFDocument.load(pdfBytes);
                        const pages = await mergedPdf.copyPages(pdfDoc, pdfDoc.getPageIndices());
                        pages.forEach(page => mergedPdf.addPage(page));
                    } catch (err) {
                        console.warn(`Gagal memproses ${pdf.letter_number}:`, err);
                    }
                }

                progressText.textContent = 'Membuat file...';
                const mergedBytes = await mergedPdf.save();

                // Download
                const blob = new Blob([mergedBytes], {
                    type: 'application/pdf'
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);

                progressText.textContent = 'Selesai!';
                progressBar.style.width = '100%';
                progressBar.classList.remove('bg-blue-500');
                progressBar.classList.add('bg-green-500');

            } catch (err) {
                console.error('Error merging PDFs:', err);
                alert('Gagal menggabungkan PDF: ' + err.message);
                progressContainer.classList.add('hidden');
            } finally {
                // Re-enable buttons
                mergeBtn.disabled = false;
                mergeSelectedBtn.disabled = selectedIndices.length < 2;
                document.getElementById('mergeBtnText').textContent = 'Gabung Semua PDF';

                // Hide progress after 3 seconds
                setTimeout(() => {
                    progressContainer.classList.add('hidden');
                    progressBar.classList.remove('bg-green-500');
                    progressBar.classList.add('bg-blue-500');
                }, 3000);
            }
        }
    </script>
    @endpush
</x-app-layout>