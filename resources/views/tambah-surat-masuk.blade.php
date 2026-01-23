<x-app-layout>
  <div class="min-h-screen bg-[#f5f7fb]">
    <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6">
      <a href="{{ route('surat-masuk.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-orange-500 font-semibold text-sm no-underline transition-colors">
        <i class="bi bi-arrow-left"></i> Kembali ke Surat Masuk
      </a>

      <h1 class="mt-4 mb-1 text-2xl font-extrabold text-gray-900">Tambah Surat Masuk</h1>
      <p class="text-gray-500 text-sm mb-6">Gunakan formulir berikut untuk mencatat surat masuk ke dalam sistem.</p>

      <form method="POST" action="{{ route('surat-masuk.store') }}" enctype="multipart/form-data">
        @csrf
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
              <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" name="letter_number" value="{{ old('letter_number') }}" placeholder="Masukkan nomor surat" required />
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-700 mb-2">No Index <span class="text-red-500">*</span></label>
              <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" type="number" min="1" name="index_no" value="{{ old('index_no', $nextIndexNo) }}" placeholder="Nomor index" required />
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-700 mb-2">Pengirim <span class="text-red-500">*</span></label>
              <div class="relative">
                <input id="sender-input" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition pr-16" name="sender" value="{{ old('sender') }}" placeholder="Nama instansi/organisasi pengirim" autocomplete="off" required />
                <button type="button" data-clear-target="sender-input" class="absolute right-10 top-1/2 -translate-y-1/2 text-gray-300 hover:text-orange-500 transition hidden" aria-label="Hapus pengirim">
                  <i class="bi bi-x-lg"></i>
                </button>
                <button type="button" id="sender-toggle" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition" aria-label="Tampilkan daftar pengirim">
                  <i class="bi bi-chevron-down"></i>
                </button>
                <div id="sender-dropdown" class="absolute z-10 mt-2 w-full bg-white border border-gray-200 rounded-xl shadow-lg max-h-56 overflow-auto hidden">
                  @foreach ($senderOptions ?? [] as $senderOption)
                    <button type="button" class="sender-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-orange-50">
                      {{ $senderOption }}
                    </button>
                  @endforeach
                </div>
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-gray-700 mb-2">Tanggal Surat <span class="text-red-500">*</span></label>
              <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" type="date" name="letter_date" value="{{ old('letter_date') }}" required />
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-700 mb-2">Tanggal Diterima <span class="text-red-500">*</span></label>
              <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" type="date" name="received_date" value="{{ old('received_date', $defaultReceivedDate->format('Y-m-d')) }}" required />
            </div>

            <div>
              <label class="block text-xs font-bold text-gray-700 mb-2">Jenis Surat <span class="text-red-500">*</span></label>
              <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-50" value="Surat Masuk" readonly />
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-700 mb-2">Kategori Surat <span class="text-red-500">*</span></label>
              <div class="relative">
                <input id="category-input" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition pr-16" name="category" value="{{ old('category') }}" placeholder="Pilih atau ketik kategori surat" autocomplete="off" required />
                <button type="button" data-clear-target="category-input" class="absolute right-10 top-1/2 -translate-y-1/2 text-gray-300 hover:text-orange-500 transition hidden" aria-label="Hapus kategori">
                  <i class="bi bi-x-lg"></i>
                </button>
                <button type="button" id="category-toggle" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition" aria-label="Tampilkan daftar kategori">
                  <i class="bi bi-chevron-down"></i>
                </button>
                <div id="category-dropdown" class="absolute z-10 mt-2 w-full bg-white border border-gray-200 rounded-xl shadow-lg max-h-56 overflow-auto hidden">
                  @foreach ($categories as $category)
                    <button type="button" class="category-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-orange-50">
                      {{ $category }}
                    </button>
                  @endforeach
                </div>
              </div>
            </div>

            <div class="md:col-span-2">
              <label class="block text-xs font-bold text-gray-700 mb-2">Perihal <span class="text-red-500">*</span></label>
              <input class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" name="subject" value="{{ old('subject') }}" placeholder="Masukkan perihal surat" required />
            </div>

            <div class="md:col-span-2">
              <label class="block text-xs font-bold text-gray-700 mb-2">Ringkasan Isi Surat <span class="text-gray-400 font-normal">(Opsional)</span></label>
              <textarea class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" name="summary" rows="4" placeholder="Ringkasan singkat isi surat...">{{ old('summary') }}</textarea>
              <div class="text-gray-400 text-xs flex items-center gap-2 mt-2"><i class="bi bi-info-circle"></i> Ringkasan isi surat digunakan sebagai gambaran umum isi dokumen.</div>
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

          <div class="relative border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center bg-white transition hover:border-orange-300" data-upload>
            <input type="file" id="lampiran-file-masuk" name="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" data-upload-input />
            <div class="flex flex-col items-center gap-3">
              <div class="text-4xl text-gray-300"><i class="bi bi-cloud-arrow-up"></i></div>
              <h6 class="font-bold text-gray-900">Unggah atau Ambil Foto Surat</h6>
              <p class="text-gray-400 text-sm">Format yang didukung: PDF, JPG, PNG, DOC, DOCX | Maksimal 10 MB</p>
              <div class="flex justify-center gap-3 mt-2">
                <label class="inline-flex items-center px-4 py-2 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 cursor-pointer transition" for="lampiran-file-masuk">
                  <i class="bi bi-folder2-open me-2"></i>Pilih File
                </label>
                <button class="inline-flex items-center px-4 py-2 bg-orange-500 text-white rounded-xl text-sm font-bold hover:bg-orange-600 transition" type="button" data-upload-ignore id="btn-open-camera">
                  <i class="bi bi-camera me-2"></i>Buka Kamera
                </button>
              </div>
              <div class="mt-3" data-upload-preview>
                <div class="text-gray-400 text-sm" data-upload-empty>Belum ada file dipilih.</div>
              </div>
              <!-- Custom filename input -->
              <div class="w-full max-w-md mt-3 hidden" id="custom-filename-wrapper">
                <label class="block text-xs font-bold text-gray-700 mb-2 text-left">Nama File (opsional)</label>
                <div class="flex items-center gap-2">
                  <input type="text" name="custom_filename" id="custom-filename-input" class="flex-1 px-4 py-2 border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition" placeholder="Masukkan nama file..." />
                  <span id="file-extension" class="text-sm text-gray-500 font-mono">.pdf</span>
                </div>
                <p class="text-xs text-gray-400 mt-1 text-left">Kosongkan untuk menggunakan nama file asli</p>
              </div>
            </div>
            <div class="absolute inset-0 rounded-2xl bg-orange-50/80 flex items-center justify-center opacity-0 transition-opacity pointer-events-none" data-drop-overlay>
              <span class="text-orange-700 font-bold text-sm">Drop file di sini</span>
            </div>
          </div>

          <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3 mt-4">
            <i class="bi bi-info-circle-fill text-blue-500 mt-0.5"></i>
            <div class="text-sm text-blue-800"><strong>Tips:</strong> Gunakan fitur kamera untuk memotret surat fisik jika belum tersedia dalam bentuk file digital.</div>
          </div>
        </section>

        <div class="flex justify-end gap-3 mt-6">
          <a class="inline-flex items-center px-6 py-2.5 border border-gray-300 rounded-xl text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition no-underline" href="{{ route('surat-masuk.index') }}">Batal</a>
          <button class="inline-flex items-center px-6 py-2.5 bg-orange-500 text-white rounded-xl text-sm font-bold hover:bg-orange-600 shadow-orange transition" type="submit">
            <i class="bi bi-floppy me-2"></i> Simpan Surat Masuk
          </button>
        </div>

        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3 mt-4">
          <i class="bi bi-exclamation-triangle-fill text-amber-500 mt-0.5"></i>
          <div class="text-sm text-amber-800">Pastikan data surat telah diisi dengan benar sebelum disimpan.</div>
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
          showCustomFilenameInput(fileInput);
        });

        fileInput.addEventListener('input', () => {
          updatePreviewFromInput();
          showCustomFilenameInput(fileInput);
        });

        resetPreview();
      });

      // Custom filename functionality
      function showCustomFilenameInput(fileInput) {
        const wrapper = document.getElementById('custom-filename-wrapper');
        const input = document.getElementById('custom-filename-input');
        const extSpan = document.getElementById('file-extension');

        if (fileInput.files && fileInput.files.length > 0) {
          const file = fileInput.files[0];
          const fileName = file.name;
          const lastDot = fileName.lastIndexOf('.');
          const ext = lastDot > 0 ? fileName.substring(lastDot) : '';
          const nameWithoutExt = lastDot > 0 ? fileName.substring(0, lastDot) : fileName;

          wrapper.classList.remove('hidden');
          input.placeholder = nameWithoutExt;
          extSpan.textContent = ext;
        } else {
          wrapper.classList.add('hidden');
          input.value = '';
        }
      }
    })();
  </script>
  <script>
    (() => {
      const input = document.getElementById('category-input');
      const toggle = document.getElementById('category-toggle');
      const dropdown = document.getElementById('category-dropdown');
      const options = Array.from(document.querySelectorAll('.category-option'));

      if (!input || !toggle || !dropdown || options.length === 0) {
        return;
      }

      const normalize = (value) => value.trim().toLowerCase();
      const filterOptions = (value) => {
        const needle = normalize(value);
        let visibleCount = 0;
        options.forEach((option) => {
          const match = normalize(option.textContent || '').includes(needle);
          option.classList.toggle('hidden', !match);
          if (match) visibleCount += 1;
        });
        dropdown.classList.toggle('hidden', visibleCount === 0);
      };

      const openDropdown = () => {
        filterOptions(input.value);
        dropdown.classList.remove('hidden');
      };

      const closeDropdown = () => {
        dropdown.classList.add('hidden');
      };

      toggle.addEventListener('click', () => {
        if (dropdown.classList.contains('hidden')) {
          openDropdown();
        } else {
          closeDropdown();
        }
      });

      input.addEventListener('focus', openDropdown);
      input.addEventListener('input', () => filterOptions(input.value));

      options.forEach((option) => {
        option.addEventListener('click', () => {
          input.value = option.textContent.trim();
          closeDropdown();
        });
      });

      document.addEventListener('click', (event) => {
        if (!dropdown.contains(event.target) && !input.contains(event.target) && !toggle.contains(event.target)) {
          closeDropdown();
        }
      });
    })();
  </script>
  <script>
    (() => {
      const clearButtons = Array.from(document.querySelectorAll('[data-clear-target]'));
      if (clearButtons.length === 0) {
        return;
      }

      const updateButton = (input, button) => {
        const hasValue = Boolean(input.value && input.value.trim());
        button.classList.toggle('hidden', !hasValue);
      };

      clearButtons.forEach((button) => {
        const targetId = button.getAttribute('data-clear-target');
        const input = document.getElementById(targetId);
        if (!input) {
          return;
        }

        updateButton(input, button);
        input.addEventListener('input', () => updateButton(input, button));
        input.addEventListener('change', () => updateButton(input, button));

        button.addEventListener('click', () => {
          input.value = '';
          updateButton(input, button);
          input.focus();
          input.dispatchEvent(new Event('input', { bubbles: true }));
          input.dispatchEvent(new Event('change', { bubbles: true }));
        });
      });
    })();
  </script>
  <script>
    (() => {
      const input = document.getElementById('sender-input');
      const toggle = document.getElementById('sender-toggle');
      const dropdown = document.getElementById('sender-dropdown');
      const options = Array.from(document.querySelectorAll('.sender-option'));

      if (!input || !toggle || !dropdown || options.length === 0) {
        return;
      }

      const normalize = (value) => value.trim().toLowerCase();
      const filterOptions = (value) => {
        const needle = normalize(value);
        let visibleCount = 0;
        options.forEach((option) => {
          const match = normalize(option.textContent || '').includes(needle);
          option.classList.toggle('hidden', !match);
          if (match) visibleCount += 1;
        });
        dropdown.classList.toggle('hidden', visibleCount === 0);
      };

      const openDropdown = () => {
        filterOptions(input.value);
        dropdown.classList.remove('hidden');
      };

      const closeDropdown = () => {
        dropdown.classList.add('hidden');
      };

      toggle.addEventListener('click', () => {
        if (dropdown.classList.contains('hidden')) {
          openDropdown();
        } else {
          closeDropdown();
        }
      });

      input.addEventListener('focus', openDropdown);
      input.addEventListener('input', () => filterOptions(input.value));

      options.forEach((option) => {
        option.addEventListener('click', () => {
          input.value = option.textContent.trim();
          closeDropdown();
        });
      });

      document.addEventListener('click', (event) => {
        if (!dropdown.contains(event.target) && !input.contains(event.target) && !toggle.contains(event.target)) {
          closeDropdown();
        }
      });
    })();
  </script>

  <!-- Camera Modal -->
  <div id="camera-modal" class="fixed inset-0 bg-black/70 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full mx-4 overflow-hidden">
      <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
        <h3 class="font-bold text-gray-900">Ambil Foto Surat</h3>
        <button type="button" id="btn-close-camera" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
          <i class="bi bi-x-lg text-gray-500"></i>
        </button>
      </div>
      <div class="p-5">
        <div class="relative bg-black rounded-xl overflow-hidden aspect-video">
          <video id="camera-video" class="w-full h-full object-cover" autoplay playsinline></video>
          <canvas id="camera-canvas" class="hidden"></canvas>
          <div id="camera-loading" class="absolute inset-0 flex items-center justify-center bg-gray-900">
            <div class="text-center text-white">
              <div class="animate-spin rounded-full h-8 w-8 border-2 border-white border-t-transparent mx-auto mb-2"></div>
              <p class="text-sm">Mengakses kamera...</p>
            </div>
          </div>
          <div id="camera-error" class="absolute inset-0 flex items-center justify-center bg-gray-900 hidden">
            <div class="text-center text-white px-4">
              <i class="bi bi-camera-video-off text-4xl mb-2"></i>
              <p class="text-sm">Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.</p>
            </div>
          </div>
        </div>
        <div id="camera-preview-container" class="hidden mt-4">
          <p class="text-sm text-gray-500 mb-2">Hasil foto:</p>
          <img id="camera-preview-img" class="rounded-xl border border-gray-200 max-h-48 mx-auto" />
        </div>
      </div>
      <div class="flex items-center justify-end gap-3 px-5 py-4 border-t border-gray-100">
        <button type="button" id="btn-retake" class="hidden px-4 py-2 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition">
          <i class="bi bi-arrow-counterclockwise me-2"></i>Ulangi
        </button>
        <button type="button" id="btn-capture" class="px-4 py-2 bg-orange-500 text-white rounded-xl text-sm font-bold hover:bg-orange-600 transition">
          <i class="bi bi-camera me-2"></i>Ambil Foto
        </button>
        <button type="button" id="btn-use-photo" class="hidden px-4 py-2 bg-green-500 text-white rounded-xl text-sm font-bold hover:bg-green-600 transition">
          <i class="bi bi-check-lg me-2"></i>Gunakan Foto
        </button>
      </div>
    </div>
  </div>

  <script>
    (() => {
      const btnOpenCamera = document.getElementById('btn-open-camera');
      const modal = document.getElementById('camera-modal');
      const btnCloseCamera = document.getElementById('btn-close-camera');
      const video = document.getElementById('camera-video');
      const canvas = document.getElementById('camera-canvas');
      const btnCapture = document.getElementById('btn-capture');
      const btnRetake = document.getElementById('btn-retake');
      const btnUsePhoto = document.getElementById('btn-use-photo');
      const cameraLoading = document.getElementById('camera-loading');
      const cameraError = document.getElementById('camera-error');
      const previewContainer = document.getElementById('camera-preview-container');
      const previewImg = document.getElementById('camera-preview-img');
      const fileInput = document.getElementById('lampiran-file-masuk');

      let stream = null;
      let capturedBlob = null;

      const openCamera = async () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        cameraLoading.classList.remove('hidden');
        cameraError.classList.add('hidden');
        previewContainer.classList.add('hidden');
        btnCapture.classList.remove('hidden');
        btnRetake.classList.add('hidden');
        btnUsePhoto.classList.add('hidden');

        try {
          stream = await navigator.mediaDevices.getUserMedia({
            video: {
              facingMode: 'environment',
              width: {
                ideal: 1920
              },
              height: {
                ideal: 1080
              }
            },
            audio: false
          });
          video.srcObject = stream;
          video.onloadedmetadata = () => {
            cameraLoading.classList.add('hidden');
          };
        } catch (err) {
          console.error('Camera error:', err);
          cameraLoading.classList.add('hidden');
          cameraError.classList.remove('hidden');
        }
      };

      const closeCamera = () => {
        if (stream) {
          stream.getTracks().forEach(track => track.stop());
          stream = null;
        }
        video.srcObject = null;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        capturedBlob = null;
      };

      const capturePhoto = () => {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0);

        canvas.toBlob((blob) => {
          capturedBlob = blob;
          previewImg.src = URL.createObjectURL(blob);
          previewContainer.classList.remove('hidden');
          btnCapture.classList.add('hidden');
          btnRetake.classList.remove('hidden');
          btnUsePhoto.classList.remove('hidden');

          // Pause video
          if (stream) {
            stream.getTracks().forEach(track => track.stop());
          }
        }, 'image/jpeg', 0.9);
      };

      const retakePhoto = async () => {
        capturedBlob = null;
        previewContainer.classList.add('hidden');
        btnCapture.classList.remove('hidden');
        btnRetake.classList.add('hidden');
        btnUsePhoto.classList.add('hidden');

        // Restart camera
        try {
          stream = await navigator.mediaDevices.getUserMedia({
            video: {
              facingMode: 'environment',
              width: {
                ideal: 1920
              },
              height: {
                ideal: 1080
              }
            },
            audio: false
          });
          video.srcObject = stream;
        } catch (err) {
          console.error('Camera error:', err);
        }
      };

      const usePhoto = () => {
        if (!capturedBlob) return;

        const fileName = `foto_surat_${Date.now()}.jpg`;
        const file = new File([capturedBlob], fileName, {
          type: 'image/jpeg'
        });

        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;

        // Trigger change event
        fileInput.dispatchEvent(new Event('change', {
          bubbles: true
        }));

        closeCamera();
      };

      btnOpenCamera.addEventListener('click', openCamera);
      btnCloseCamera.addEventListener('click', closeCamera);
      btnCapture.addEventListener('click', capturePhoto);
      btnRetake.addEventListener('click', retakePhoto);
      btnUsePhoto.addEventListener('click', usePhoto);

      // Close modal on backdrop click
      modal.addEventListener('click', (e) => {
        if (e.target === modal) closeCamera();
      });

      // Close on escape key
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
          closeCamera();
        }
      });
    })();
  </script>
</x-app-layout>
