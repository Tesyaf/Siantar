<x-app-layout>

  <!-- BACK -->
  <div class="max-w-7xl mx-auto px-6 py-4">
    <a href="{{ route('welcome') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-orange-500 transition font-medium">
      <i class="bi bi-arrow-left"></i> <span>Kembali</span>
    </a>
  </div>

  <!-- HEADING -->
  <div class="text-center mt-4">
    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
      Tentang Sistem SIANTAR
    </h1>
    <div class="w-16 h-1 bg-orange-500 rounded-full mx-auto mt-3"></div>
    <p class="text-gray-500 mt-4 max-w-2xl mx-auto leading-relaxed">
      Solusi digital untuk modernisasi tata kelola persuratan dan pengarsipan naskah di
      lingkungan Badan Kesatuan Bangsa dan Politik
    </p>
  </div>

  <!-- DESCRIPTION SECTION -->
  <div class="bg-gray-50 py-12 mt-10">
    <div class="max-w-4xl mx-auto px-6">
      <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8 text-base leading-relaxed text-gray-600">
        SIANTAR (Sistem Arsip Naskah dan Tata Persuratan) merupakan sistem informasi berbasis web
        yang dikembangkan untuk mendukung pengelolaan surat masuk, surat keluar, serta arsip
        naskah secara digital. Sistem ini dirancang untuk meningkatkan efisiensi kerja,
        ketertiban administrasi, serta kemudahan dalam pengelolaan dan pencarian dokumen persuratan
        di lingkungan instansi pemerintahan.
      </div>
    </div>
  </div>

  <!-- FITUR UTAMA -->
  <div class="text-center mt-16">
    <h2 class="text-2xl font-bold text-gray-900">Fitur Utama Sistem</h2>
    <div class="w-12 h-1 bg-orange-500 rounded-full mx-auto mt-2"></div>
  </div>

  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mt-10 px-6">

    <div class="bg-orange-50 rounded-2xl p-8 text-center border border-orange-100 shadow-sm hover:shadow-md transition-all duration-300">
      <div class="w-14 h-14 mx-auto rounded-xl bg-orange-500 flex items-center justify-center text-white mb-4 shadow-orange">
        <i class="bi bi-inbox-fill text-xl"></i>
      </div>
      <p class="font-bold text-gray-900 mb-2">Surat Masuk</p>
      <p class="text-sm text-gray-600">
        Pendaftaran surat masuk secara digital dengan dukungan sistem disposisi dan notifikasi real-time.
      </p>
    </div>

    <div class="bg-orange-50 rounded-2xl p-8 text-center border border-orange-100 shadow-sm hover:shadow-md transition-all duration-300">
      <div class="w-14 h-14 mx-auto rounded-xl bg-orange-500 flex items-center justify-center text-white mb-4 shadow-orange">
        <i class="bi bi-send-fill text-xl"></i>
      </div>
      <p class="font-bold text-gray-900 mb-2">Surat Keluar</p>
      <p class="text-sm text-gray-600">
        Pembuatan dan pengiriman surat keluar dengan alur persetujuan bertingkat.
      </p>
    </div>

    <div class="bg-orange-50 rounded-2xl p-8 text-center border border-orange-100 shadow-sm hover:shadow-md transition-all duration-300">
      <div class="w-14 h-14 mx-auto rounded-xl bg-orange-500 flex items-center justify-center text-white mb-4 shadow-orange">
        <i class="bi bi-archive-fill text-xl"></i>
      </div>
      <p class="font-bold text-gray-900 mb-2">Arsip Digital</p>
      <p class="text-sm text-gray-600">
        Penyimpanan arsip naskah secara terstruktur dengan sistem pencarian cepat, aman, dan mudah diakses.
      </p>
    </div>

  </div>

  <!-- TUJUAN SECTION -->
  <div class="bg-gray-50 py-12 mt-16">
    <div class="max-w-4xl mx-auto px-6">
      <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8 text-center">
        <div class="w-14 h-14 mx-auto rounded-xl bg-orange-500 flex items-center justify-center text-white mb-4 shadow-orange">
          <i class="bi bi-bullseye text-xl"></i>
        </div>
        <p class="font-bold text-lg text-gray-900 mb-2">Tujuan Sistem</p>
        <p class="text-gray-600 leading-relaxed max-w-2xl mx-auto">
          SIANTAR dikembangkan untuk mendukung modernisasi tata kelola persuratan, mengurangi penggunaan arsip fisik,
          serta meningkatkan transparansi dan akuntabilitas dalam pengelolaan dokumen.
        </p>
      </div>
    </div>
  </div>

  <!-- MANFAAT SISTEM -->
  <div class="text-center mt-16">
    <h2 class="text-2xl font-bold text-gray-900">
      Manfaat Sistem
    </h2>
    <div class="w-12 h-1 bg-orange-500 rounded-full mx-auto mt-2"></div>
  </div>

  <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 mt-10 mb-20 px-6">

    <div class="flex gap-4">
      <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center shrink-0">
        <i class="bi bi-clock-fill text-orange-500"></i>
      </div>
      <div>
        <p class="font-bold text-gray-900">Efisiensi Waktu</p>
        <p class="text-sm text-gray-600 mt-1">
          Mempercepat proses administrasi dan pengelolaan dokumen
        </p>
      </div>
    </div>

    <div class="flex gap-4">
      <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center shrink-0">
        <i class="bi bi-shield-fill-check text-orange-500"></i>
      </div>
      <div>
        <p class="font-bold text-gray-900">Keamanan Data</p>
        <p class="text-sm text-gray-600 mt-1">
          Sistem keamanan berlapis untuk melindungi dokumen penting
        </p>
      </div>
    </div>

    <div class="flex gap-4">
      <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center shrink-0">
        <i class="bi bi-search text-orange-500"></i>
      </div>
      <div>
        <p class="font-bold text-gray-900">Pencarian Mudah</p>
        <p class="text-sm text-gray-600 mt-1">
          Fitur pencarian canggih untuk menemukan dokumen dengan cepat
        </p>
      </div>
    </div>

    <div class="flex gap-4">
      <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center shrink-0">
        <i class="bi bi-clipboard-check-fill text-orange-500"></i>
      </div>
      <div>
        <p class="font-bold text-gray-900">Transparansi</p>
        <p class="text-sm text-gray-600 mt-1">
          Meningkatkan akuntabilitas dalam pengelolaan persuratan
        </p>
      </div>
    </div>

  </div>

</x-app-layout>
