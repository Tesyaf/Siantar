<x-app-layout>
<div class="bg-[#f5f7fb]">
<main class="container py-4">
    <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none fw-semibold d-inline-flex align-items-center gap-2 hover:text-gray-800">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <div class="text-center mt-2">
      <h1 class="mt-2 mb-1 text-4xl font-extrabold text-gray-900">Tambah Surat</h1>
      <p class="text-gray-500 mb-0">Pilih jenis surat yang ingin Anda tambahkan ke dalam sistem.</p>
    </div>

    <div class="row justify-content-center g-4 mt-4">
      <div class="col-lg-5">
        <div class="bg-white border border-gray-200 rounded-4 shadow-sm p-4 text-center h-100">
          <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-[#ff7f00] text-white shadow-sm mb-3 w-16 h-16 text-2xl">
            <i class="bi bi-inbox-fill"></i>
          </div>
          <div class="text-2xl fw-bold mb-2 text-gray-900">Surat Masuk</div>
          <p class="text-muted mb-4 mx-auto max-w-sm">Digunakan untuk mencatat dan mengelola surat yang diterima dari instansi atau pihak lain.</p>
          <a href="{{ route('tambah-surat-masuk') }}" class="btn w-100 fw-bold text-white bg-[#ff7f00] hover:bg-[#f36f00] border-0 max-w-sm mx-auto">Tambah Surat Masuk</a>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="bg-white border border-gray-200 rounded-4 shadow-sm p-4 text-center h-100">
          <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-[#ff7f00] text-white shadow-sm mb-3 w-16 h-16 text-2xl">
            <i class="bi bi-send-fill"></i>
          </div>
          <div class="text-2xl fw-bold mb-2 text-gray-900">Surat Keluar</div>
          <p class="text-muted mb-4 mx-auto max-w-sm">Digunakan untuk membuat dan mencatat surat yang akan dikirim ke instansi atau pihak lain.</p>
          <a href="{{ route('tambah-surat-keluar') }}" class="btn w-100 fw-bold text-white bg-[#ff7f00] hover:bg-[#f36f00] border-0 max-w-sm mx-auto">Tambah Surat Keluar</a>
        </div>
      </div>
    </div>

    <div class="alert alert-info d-flex align-items-center gap-2 mt-4 max-w-3xl mx-auto" role="alert">
      <i class="bi bi-info-circle-fill"></i>
      <div>Setelah memilih jenis surat, Anda akan diarahkan ke formulir pengisian data surat sesuai dengan jenis yang dipilih.</div>
    </div>
  </main>
</div>
</x-app-layout>









