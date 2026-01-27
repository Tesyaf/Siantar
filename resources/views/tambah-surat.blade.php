<x-app-layout>
  <div class="min-h-screen bg-[#f5f7fb]">
    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-6">
      <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-orange-500 transition font-medium text-sm">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
      </a>

      <div class="text-center mt-6 mb-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">Tambah Surat</h1>
        <div class="w-16 h-1 bg-orange-500 mx-auto rounded-full mt-3 mb-4"></div>
        <p class="text-gray-500">Pilih jenis surat yang ingin Anda tambahkan ke dalam sistem.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8 text-center hover:shadow-lg hover:border-orange-200 transition-all duration-300 group">
          <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 text-white flex items-center justify-center text-2xl shadow-orange group-hover:scale-110 transition-transform duration-300">
            <i class="bi bi-inbox-fill"></i>
          </div>
          <h3 class="text-xl font-bold mb-2 text-gray-900">Surat Masuk</h3>
          <p class="text-gray-500 text-sm mb-6">Digunakan untuk mencatat dan mengelola surat yang diterima dari instansi atau pihak lain.</p>
          <a href="{{ route('tambah-surat-masuk') }}" class="inline-flex items-center justify-center w-full px-5 py-3 bg-orange-500 text-white font-bold text-sm rounded-xl shadow-orange hover:bg-orange-600 transition duration-200">
            <i class="bi bi-plus-lg mr-2"></i> Tambah Surat Masuk
          </a>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8 text-center hover:shadow-lg hover:border-orange-200 transition-all duration-300 group">
          <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 text-white flex items-center justify-center text-2xl shadow-orange group-hover:scale-110 transition-transform duration-300">
            <i class="bi bi-send-fill"></i>
          </div>
          <h3 class="text-xl font-bold mb-2 text-gray-900">Surat Keluar</h3>
          <p class="text-gray-500 text-sm mb-6">Digunakan untuk membuat dan mencatat surat yang akan dikirim ke instansi atau pihak lain.</p>
          <a href="{{ route('tambah-surat-keluar') }}" class="inline-flex items-center justify-center w-full px-5 py-3 bg-orange-500 text-white font-bold text-sm rounded-xl shadow-orange hover:bg-orange-600 transition duration-200">
            <i class="bi bi-plus-lg mr-2"></i> Tambah Surat Keluar
          </a>
        </div>
      </div>

      <div class="flex items-start gap-3 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-sm mt-8 max-w-3xl mx-auto">
        <i class="bi bi-info-circle-fill mt-0.5"></i>
        <div>Setelah memilih jenis surat, Anda akan diarahkan ke formulir pengisian data surat sesuai dengan jenis yang dipilih.</div>
      </div>
    </main>
  </div>
</x-app-layout>