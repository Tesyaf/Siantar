<x-app-layout>
<div class="bg-[#f5f7fb]">
<main class="container py-4">
    <a href="{{ route('surat-keluar.index') }}" class="text-muted text-decoration-none fw-semibold d-inline-flex align-items-center gap-2 hover:text-gray-800">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <h1 class="mt-2 mb-1 text-3xl font-extrabold text-gray-900">Tambah Surat Keluar</h1>
    <p class="text-gray-500 mb-4">Gunakan formulir berikut untuk membuat dan mencatat surat keluar.</p>

    <form method="POST" action="{{ route('surat-keluar.store') }}" enctype="multipart/form-data">
    @csrf
    <section class="bg-white border border-gray-200 rounded-3 shadow-sm p-3 p-lg-4">
      <div class="d-flex align-items-center gap-2 fw-bold text-gray-900 mb-3">
        <span class="d-inline-flex align-items-center justify-content-center rounded-2 bg-orange-100 text-orange-600 border border-orange-200 w-7 h-7 text-sm">
          <i class="bi bi-envelope-fill"></i>
        </span>
        Informasi Surat
      </div>

      <div class="row g-3">
        <div class="col-lg-6">
          <div class="fw-bold text-gray-700 small mb-2">Nomor Urut Surat <span class="text-danger">*</span></div>
          <input class="form-control" name="letter_number" value="{{ old('letter_number') }}" placeholder="Masukkan nomor surat" required />
        </div>
        <div class="col-lg-6">
          <div class="fw-bold text-gray-700 small mb-2">Alamat Penerima <span class="text-danger">*</span></div>
          <input class="form-control" name="recipient" value="{{ old('recipient') }}" placeholder="Nama instansi/organisasi pengirim" required />
        </div>

        <div class="col-lg-6">
          <div class="fw-bold text-gray-700 small mb-2">Tanggal Surat <span class="text-danger">*</span></div>
          <div class="input-group">
            <input class="form-control" type="date" name="letter_date" value="{{ old('letter_date') }}" required />
            <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="fw-bold text-gray-700 small mb-2">Jenis Surat <span class="text-danger">*</span></div>
          <input class="form-control" value="Surat Keluar" readonly />
        </div>

        <div class="col-lg-6">
          <div class="fw-bold text-gray-700 small mb-2">Sifat Surat <span class="text-danger">*</span></div>
          <select class="form-select" name="priority">
            <option value="" selected>Pilih sifat surat</option>
            <option value="Biasa" @selected(old('priority') === 'Biasa')>Biasa</option>
            <option value="Penting" @selected(old('priority') === 'Penting')>Penting</option>
            <option value="Rahasia" @selected(old('priority') === 'Rahasia')>Rahasia</option>
          </select>
        </div>
        <div class="col-lg-6">
          <div class="fw-bold text-gray-700 small mb-2">Kategori Surat <span class="text-danger">*</span></div>
          <select class="form-select" name="category">
            <option value="" selected>Pilih kategori surat</option>
            <option value="Undangan" @selected(old('category') === 'Undangan')>Undangan</option>
            <option value="Laporan" @selected(old('category') === 'Laporan')>Laporan</option>
            <option value="Permohonan" @selected(old('category') === 'Permohonan')>Permohonan</option>
          </select>
        </div>

        <div class="col-12">
          <div class="fw-bold text-gray-700 small mb-2">Perihal <span class="text-danger">*</span></div>
          <input class="form-control" name="subject" value="{{ old('subject') }}" placeholder="Masukkan perihal surat" required />
        </div>

        <div class="col-12">
          <div class="fw-bold text-gray-700 small mb-2">Ringkasan Isi Surat <span class="text-muted">(Opsional)</span></div>
          <textarea class="form-control" name="summary" rows="4" placeholder="Dengan hormat, Sehubungan dengan... Demikian surat ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.">{{ old('summary') }}</textarea>
          <div class="text-muted small d-flex align-items-center gap-2 mt-2"><i class="bi bi-info-circle"></i> Ringkasan isi surat digunakan sebagai gambaran umum isi dokumen.</div>
        </div>

        <div class="col-12 mt-2">
          <div class="fw-bold text-gray-700 small mb-1">Data Tambahan <span class="text-muted">(Opsional)</span></div>
        </div>
        <div class="col-lg-4">
          <div class="fw-bold text-gray-700 small mb-2">Nomor Berkas <span class="text-muted">(Opsional)</span></div>
          <input class="form-control" name="file_number" value="{{ old('file_number') }}" placeholder="Nomor berkas" />
        </div>
        <div class="col-lg-4">
          <div class="fw-bold text-gray-700 small mb-2">Nomor Petunjuk <span class="text-muted">(Opsional)</span></div>
          <input class="form-control" name="instruction_number" value="{{ old('instruction_number') }}" placeholder="Nomor petunjuk" />
        </div>
        <div class="col-lg-4">
          <div class="fw-bold text-gray-700 small mb-2">Nomor Paket <span class="text-muted">(Opsional)</span></div>
          <input class="form-control" name="package_number" value="{{ old('package_number') }}" placeholder="Nomor paket" />
        </div>
      </div>
    </section>

    <section class="bg-white border border-gray-200 rounded-3 shadow-sm p-3 p-lg-4 mt-3">
      <div class="d-flex align-items-center gap-2 fw-bold text-gray-900 mb-3">
        <span class="d-inline-flex align-items-center justify-content-center rounded-2 bg-orange-100 text-orange-600 border border-orange-200 w-7 h-7 text-sm">
          <i class="bi bi-paperclip"></i>
        </span>
        Lampiran Dokumen
      </div>

      <div class="position-relative border border-2 border-dashed border-gray-300 rounded-3 p-4 text-center bg-white transition" data-upload>
        <input type="file" id="lampiran-file-keluar" name="file" class="visually-hidden" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" data-upload-input />
        <div class="d-flex flex-column align-items-center gap-2">
          <div class="text-3xl text-gray-400"><i class="bi bi-cloud-arrow-up"></i></div>
          <h6 class="fw-bold mb-0 text-gray-900">Unggah atau Ambil Foto Surat</h6>
          <p class="text-muted small mb-2">Format yang didukung: PDF, JPG, PNG, DOC, DOCX | Maksimal 10 MB</p>
          <div class="d-flex justify-content-center gap-2">
            <label class="btn btn-light btn-sm border border-gray-200 fw-bold" for="lampiran-file-keluar">
              <i class="bi bi-folder2-open me-2"></i>Pilih File
            </label>
            <button class="btn btn-sm text-white bg-[#ff7f00] hover:bg-[#f36f00] border-0 fw-bold" type="button" data-upload-ignore>
              <i class="bi bi-camera me-2"></i>Buka Kamera
            </button>
          </div>
          <div class="mt-2 d-flex justify-content-center" data-upload-preview>
            <div class="text-muted small" data-upload-empty>Belum ada file dipilih.</div>
          </div>
        </div>
        <div class="position-absolute top-0 start-0 w-100 h-100 rounded-3 bg-orange-50/80 d-flex align-items-center justify-content-center opacity-0 transition-opacity pointer-events-none" data-drop-overlay>
          <span class="text-orange-700 fw-bold small">Drop file di sini</span>
        </div>
      </div>

      <div class="alert alert-info d-flex align-items-start gap-2 mt-3" role="alert">
        <i class="bi bi-info-circle-fill mt-0.5"></i>
        <div><strong>Catatan:</strong> Digunakan untuk menyimpan arsip digital dari surat keluar.</div>
      </div>
    </section>

    <section class="bg-white border border-gray-200 rounded-3 shadow-sm p-3 p-lg-4 mt-3">
      <div class="d-flex align-items-center gap-2 fw-bold text-gray-900 mb-3">
        <span class="d-inline-flex align-items-center justify-content-center rounded-2 bg-orange-100 text-orange-600 border border-orange-200 w-7 h-7 text-sm">
          <i class="bi bi-diagram-3-fill"></i>
        </span>
        Status &amp; Alur <span class="text-muted">(Opsional)</span>
      </div>

      <div class="row g-3">
        <div class="col-lg-6">
          <div class="fw-bold text-gray-700 small mb-2">Status Awal Surat</div>
          <select class="form-select" name="status">
            <option value="Menunggu" @selected(old('status', 'Menunggu') === 'Menunggu')>Menunggu Persetujuan</option>
            <option value="Diproses" @selected(old('status') === 'Diproses')>Diproses</option>
            <option value="Terkirim" @selected(old('status') === 'Terkirim')>Terkirim</option>
            <option value="Selesai" @selected(old('status') === 'Selesai')>Selesai</option>
          </select>
          <div class="text-muted small d-flex align-items-center gap-2 mt-2"><i class="bi bi-info-circle"></i> Surat akan diproses sesuai alur persetujuan yang berlaku.</div>
        </div>
      </div>
    </section>

    <div class="d-flex justify-content-end gap-2 mt-3">
      <a class="btn btn-outline-secondary fw-bold" href="{{ route('surat-keluar.index') }}">Batal</a>
      <button class="btn text-white bg-[#ff7f00] hover:bg-[#f36f00] border-0 fw-bold" type="submit">
        <i class="bi bi-floppy me-2"></i> Simpan Surat Keluar
      </button>
    </div>

    <div class="alert alert-warning d-flex align-items-start gap-2 mt-3" role="alert">
      <i class="bi bi-exclamation-triangle-fill mt-0.5"></i>
      <div>Pastikan data surat telah diisi dengan benar sebelum disimpan.</div>
    </div>
    </form>

  </main>
</div>
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



