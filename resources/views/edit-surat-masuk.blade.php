<x-app-layout>
    <div class="min-h-screen bg-[#f5f7fb]">
        <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6">
            <a href="{{ route('detail-surat-masuk', $incomingLetter) }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-orange-500 font-semibold text-sm no-underline transition-colors">
                <i class="bi bi-arrow-left"></i> Kembali ke Detail Surat
            </a>

            <h1 class="mt-4 mb-1 text-2xl font-extrabold text-gray-900">Edit Surat Masuk</h1>
            <p class="text-gray-500 text-sm mb-6">Perbarui informasi surat masuk ({{ $incomingLetter->letter_number }})</p>

            @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm mb-4">{{ session('success') }}</div>
            @endif
            @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm mb-4">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('surat-masuk.update', $incomingLetter) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <section class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <div class="flex items-center gap-3 font-bold text-gray-900 mb-5">
                        <span class="w-8 h-8 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-sm">
                            <i class="bi bi-inbox-fill"></i>
                        </span>
                        Informasi Surat
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Nomor Surat <span class="text-red-500">*</span></label>
                            <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" name="letter_number" value="{{ old('letter_number', $incomingLetter->letter_number) }}" placeholder="Masukkan nomor surat" required />
                            @error('letter_number')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">No Index <span class="text-red-500">*</span></label>
                            <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" type="number" min="1" name="index_no" value="{{ old('index_no', $incomingLetter->index_no) }}" placeholder="Nomor index" required />
                            @error('index_no')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Pengirim <span class="text-red-500">*</span></label>
                            <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" name="sender" value="{{ old('sender', $incomingLetter->sender) }}" placeholder="Nama instansi/organisasi pengirim" list="sender-options" required />
                            <datalist id="sender-options">
                                @foreach ($senderOptions ?? [] as $senderOption)
                                <option value="{{ $senderOption }}"></option>
                                @endforeach
                            </datalist>
                            @error('sender')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Tanggal Surat <span class="text-red-500">*</span></label>
                            <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" type="date" name="letter_date" value="{{ old('letter_date', $incomingLetter->letter_date?->format('Y-m-d')) }}" required />
                            @error('letter_date')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Tanggal Diterima <span class="text-red-500">*</span></label>
                            <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" type="date" name="received_date" value="{{ old('received_date', $incomingLetter->received_date?->format('Y-m-d')) }}" required />
                            @error('received_date')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Jenis Surat <span class="text-red-500">*</span></label>
                            <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-50" value="Surat Masuk" readonly />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Kategori Surat <span class="text-red-500">*</span></label>
                            <select class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition appearance-none bg-white" name="category">
                                <option value="">Pilih kategori surat</option>
                                <option value="Undangan" @selected(old('category', $incomingLetter->category) === 'Undangan')>Undangan</option>
                                <option value="Laporan" @selected(old('category', $incomingLetter->category) === 'Laporan')>Laporan</option>
                                <option value="Permohonan" @selected(old('category', $incomingLetter->category) === 'Permohonan')>Permohonan</option>
                            </select>
                            @error('category')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-2">Perihal <span class="text-red-500">*</span></label>
                            <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" name="subject" value="{{ old('subject', $incomingLetter->subject) }}" placeholder="Masukkan perihal surat" required />
                            @error('subject')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-2">Ringkasan Isi Surat <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <textarea class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" name="summary" rows="4" placeholder="Ringkasan singkat isi surat...">{{ old('summary', $incomingLetter->summary) }}</textarea>
                            @error('summary')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="md:col-span-2 mt-2">
                            <div class="font-bold text-gray-700 text-sm">Data Tambahan</div>
                            <div class="text-gray-400 text-xs">Kolom opsional digunakan jika data tersedia, dapat dikosongkan bila tidak ada.</div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Nomor Berkas <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" name="index_code" value="{{ old('index_code', $incomingLetter->index_code) }}" placeholder="Masukkan nomor berkas" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Dari Surat Masuk - Tanggal <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" type="date" name="reference_letter_date" value="{{ old('reference_letter_date', $incomingLetter->reference_letter_date?->format('Y-m-d')) }}" />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Dari Surat Masuk - Nomor <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" name="reference_letter_number" value="{{ old('reference_letter_number', $incomingLetter->reference_letter_number) }}" placeholder="Masukkan nomor surat referensi" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Nomor Petunjuk <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" name="instruction_number" value="{{ old('instruction_number', $incomingLetter->instruction_number) }}" placeholder="Masukkan nomor petunjuk" />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Nomor Paket <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" name="package_number" value="{{ old('package_number', $incomingLetter->package_number) }}" placeholder="Masukkan nomor paket" />
                        </div>
                    </div>
                </section>

                <section class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mt-4">
                    <div class="flex items-center gap-3 font-bold text-gray-900 mb-5">
                        <span class="w-8 h-8 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-sm">
                            <i class="bi bi-paperclip"></i>
                        </span>
                        Lampiran Dokumen
                    </div>

                    @if ($attachment)
                    <div class="mb-4 p-4 border border-gray-200 rounded-xl bg-gray-50">
                        <div class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">File Saat Ini</div>
                        <div class="flex items-center gap-3">
                            <i class="bi bi-file-earmark text-2xl text-gray-400"></i>
                            <div>
                                <div class="font-bold text-gray-900">{{ $attachment['name'] }}</div>
                                <div class="text-gray-500 text-xs">{{ $attachment['size'] }}</div>
                            </div>
                            <a href="{{ $attachment['url'] }}" target="_blank" class="ml-auto inline-flex items-center px-3 py-1.5 border border-orange-500 text-orange-500 rounded-lg text-sm font-bold hover:bg-orange-50 transition no-underline">
                                <i class="bi bi-eye me-1"></i> Lihat
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="relative border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center bg-white transition hover:border-orange-300" data-upload>
                        <input type="file" id="lampiran-file-masuk" name="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" data-upload-input />
                        <div class="flex flex-col items-center gap-3">
                            <div class="text-4xl text-gray-300"><i class="bi bi-cloud-arrow-up"></i></div>
                            <h6 class="font-bold text-gray-900">{{ $attachment ? 'Ganti Lampiran (Opsional)' : 'Unggah Lampiran' }}</h6>
                            <p class="text-gray-400 text-sm">Format yang didukung: PDF, JPG, PNG, DOC, DOCX | Maksimal 10 MB</p>
                            <div class="flex justify-center gap-3 mt-2">
                                <label class="inline-flex items-center px-4 py-2 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 cursor-pointer transition" for="lampiran-file-masuk">
                                    <i class="bi bi-folder2-open me-2"></i>Pilih File
                                </label>
                            </div>
                            <div class="mt-3" data-upload-preview>
                                <div class="text-gray-400 text-sm" data-upload-empty>{{ $attachment ? 'Pilih file baru untuk mengganti lampiran.' : 'Belum ada file dipilih.' }}</div>
                            </div>
                        </div>
                        <div class="absolute inset-0 rounded-2xl bg-orange-50/80 flex items-center justify-center opacity-0 transition-opacity pointer-events-none" data-drop-overlay>
                            <span class="text-orange-700 font-bold text-sm">Drop file di sini</span>
                        </div>
                    </div>
                </section>

                <div class="flex justify-end gap-3 mt-6">
                    <a class="inline-flex items-center px-6 py-2.5 border border-gray-300 rounded-xl text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition no-underline" href="{{ route('detail-surat-masuk', $incomingLetter) }}">Batal</a>
                    <button class="inline-flex items-center px-6 py-2.5 bg-orange-500 text-white rounded-xl text-sm font-bold hover:bg-orange-600 shadow-orange transition" type="submit">
                        <i class="bi bi-floppy me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

        </main>
    </div>
    <script>
        (() => {
            const indexInput = document.querySelector('input[name="index_no"]');
            const receivedInput = document.querySelector('input[name="received_date"]');
            const indexNoByYear = @json($indexNoByYear ?? []);
            if (!indexInput || !receivedInput) {
                return;
            }

            let manualIndexChange = false;
            const updateIndex = () => {
                const value = receivedInput.value;
                if (!value) return;
                const year = new Date(value).getFullYear();
                if (!Number.isFinite(year)) return;
                const nextIndex = (indexNoByYear[year] ?? 0) + 1;
                indexInput.value = nextIndex;
            };

            indexInput.addEventListener('input', () => {
                manualIndexChange = true;
            });
            receivedInput.addEventListener('input', () => {
                if (!manualIndexChange) {
                    updateIndex();
                }
            });
            receivedInput.addEventListener('change', () => {
                if (!manualIndexChange) {
                    updateIndex();
                }
            });
        })();
    </script>
    <script>
        (() => {
            const uploadCards = document.querySelectorAll('[data-upload]');
            const preventDefaults = (event) => {
                event.preventDefault();
            };

            uploadCards.forEach((card) => {
                const fileInput = card.querySelector('[data-upload-input]');
                const preview = card.querySelector('[data-upload-preview]');
                const emptyPreview = preview ? preview.querySelector('[data-upload-empty]') : null;
                const overlay = card.querySelector('[data-drop-overlay]');
                if (!fileInput) {
                    return;
                }

                let dragDepth = 0;
                let lastDroppedFile = null;
                const highlight = () => {
                    card.classList.add('border-orange-500', 'bg-orange-50');
                    if (overlay) {
                        overlay.classList.add('opacity-100');
                    }
                };
                const unhighlight = () => {
                    card.classList.remove('border-orange-500', 'bg-orange-50');
                    if (overlay) {
                        overlay.classList.remove('opacity-100');
                    }
                };

                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach((eventName) => {
                    card.addEventListener(eventName, preventDefaults);
                });

                card.addEventListener('dragenter', () => {
                    dragDepth += 1;
                    highlight();
                });

                card.addEventListener('dragleave', () => {
                    dragDepth -= 1;
                    if (dragDepth <= 0) {
                        dragDepth = 0;
                        unhighlight();
                    }
                });

                card.addEventListener('dragover', (event) => {
                    event.dataTransfer.dropEffect = 'copy';
                });

                const formatSize = (bytes) => {
                    if (!Number.isFinite(bytes)) {
                        return '';
                    }
                    const units = ['B', 'KB', 'MB', 'GB'];
                    let size = bytes;
                    let unit = 0;
                    while (size >= 1024 && unit < units.length - 1) {
                        size /= 1024;
                        unit += 1;
                    }
                    const precision = size < 10 && unit > 0 ? 1 : 0;
                    return `${size.toFixed(precision)} ${units[unit]}`;
                };

                const resetPreview = () => {
                    if (!preview || !emptyPreview) {
                        return;
                    }
                    preview.innerHTML = '';
                    preview.appendChild(emptyPreview.cloneNode(true));
                };

                const renderPreview = (file) => {
                    if (!preview) {
                        return;
                    }
                    if (!file) {
                        resetPreview();
                        return;
                    }
                    preview.innerHTML = '';

                    const wrapper = document.createElement('div');
                    wrapper.className = 'd-flex align-items-center gap-2 border border-gray-200 rounded-3 bg-gray-50 px-3 py-2';

                    if (file.type && file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.className = 'w-10 h-10 rounded-2 border border-gray-200 bg-white object-cover';
                        img.alt = file.name;
                        const reader = new FileReader();
                        reader.onload = () => {
                            img.src = reader.result;
                        };
                        reader.readAsDataURL(file);
                        wrapper.appendChild(img);
                    } else {
                        const icon = document.createElement('i');
                        icon.className = 'bi bi-file-earmark text-2xl text-gray-400';
                        wrapper.appendChild(icon);
                    }

                    const info = document.createElement('div');
                    const name = document.createElement('div');
                    name.className = 'fw-bold small text-gray-700 text-truncate max-w-[240px]';
                    name.textContent = file.name;
                    const meta = document.createElement('div');
                    meta.className = 'text-muted small';
                    const ext = file.name.includes('.') ? file.name.split('.').pop().toUpperCase() : 'FILE';
                    const sizeLabel = formatSize(file.size);
                    meta.textContent = sizeLabel ? `${ext} | ${sizeLabel}` : ext;

                    info.appendChild(name);
                    info.appendChild(meta);
                    wrapper.appendChild(info);
                    preview.appendChild(wrapper);
                };

                const updatePreviewFromInput = () => {
                    if (fileInput.files && fileInput.files.length) {
                        lastDroppedFile = fileInput.files[0];
                        renderPreview(lastDroppedFile);
                        return;
                    }
                    if (lastDroppedFile) {
                        renderPreview(lastDroppedFile);
                        return;
                    }
                    renderPreview(null);
                };

                card.addEventListener('drop', (event) => {
                    dragDepth = 0;
                    unhighlight();
                    const files = event.dataTransfer.files;
                    if (!files || !files.length) {
                        return;
                    }
                    lastDroppedFile = files[0];
                    if (typeof DataTransfer !== 'undefined') {
                        const dataTransfer = new DataTransfer();
                        Array.from(files).forEach((file) => dataTransfer.items.add(file));
                        fileInput.files = dataTransfer.files;
                    } else {
                        fileInput.files = files;
                    }
                    renderPreview(lastDroppedFile);
                    setTimeout(updatePreviewFromInput, 0);
                });

                card.addEventListener('click', (event) => {
                    if (event.target.closest('[data-upload-ignore]') || event.target.closest('label')) {
                        return;
                    }
                    fileInput.click();
                });

                fileInput.addEventListener('change', () => {
                    updatePreviewFromInput();
                });

                fileInput.addEventListener('input', () => {
                    updatePreviewFromInput();
                });

                resetPreview();
            });
        })();
    </script>
</x-app-layout>
