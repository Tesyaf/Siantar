<x-app-layout>
<div class="bg-white">

<!-- BACK BUTTON -->
<div class="max-w-7xl mx-auto px-6 py-4 text-[12px] flex items-center gap-2">
  <a href="{{ route('welcome') }}" class="inline-flex items-center gap-2 hover:text-orange-500 transition cursor-pointer">
    <i class="bi bi-arrow-left text-gray-600"></i> <span class="text-gray-700">Kembali</span>
  </a>
</div>

<!-- TITLE -->
<div class="text-center mt-1">
  <span class="bg-[#FFF2D8] text-[#F97316] text-[11px] font-semibold px-3 py-1 rounded-full">KEUNGGULAN SISTEM</span>
  <h1 class="text-2xl md:text-3xl font-extrabold mt-3">Manfaat SIANTAR untuk Instansi</h1>
  <p class="text-[12px] text-gray-600 mt-2 max-w-3xl mx-auto leading-relaxed">
    Sistem Arsip Naskah dan Tata Persuratan (SIANTAR) memberikan solusi komprehensif untuk transformasi digital administrasi instansi pemerintahan.
    Dengan teknologi modern dan antarmuka yang intuitif, SIANTAR memungkinkan pengelolaan dokumen yang lebih efisien, aman, dan terintegrasi.
  </p>
</div>

<!-- TOP CARDS -->
<div class="bg-gray-50 py-16 mt-16">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-6">

    <div class="rounded-2xl p-6 text-center bg-[#FFF2DC] shadow-sm">
      <div class="w-12 h-12 rounded-full bg-orange-500 flex items-center justify-center mx-auto mb-2 text-white">
        <i class="bi bi-leaf"></i>
      </div>
      <p class="font-extrabold text-[22px] text-gray-900">100%</p>
      <p class="font-semibold text-[13px] mt-1">Paperless</p>
      <p class="text-[11px] text-gray-500 -mt-0.5">Bebas kertas sepenuhnya</p>
    </div>

    <div class="rounded-2xl p-6 text-center bg-[#E6FFEA] shadow-sm">
      <div class="w-12 h-12 rounded-full bg-[#22C55E] flex items-center justify-center mx-auto mb-2 text-white">
        <i class="bi bi-rocket"></i>
      </div>
      <p class="font-extrabold text-[22px] text-gray-900">70%</p>
      <p class="font-semibold text-[13px] mt-1">Lebih Cepat</p>
      <p class="text-[11px] text-gray-500 -mt-0.5">Peningkatan kecepatan proses</p>
    </div>

    <div class="rounded-2xl p-6 text-center bg-[#E6F0FF] shadow-sm">
      <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center mx-auto mb-2 text-white">
        <i class="bi bi-shield-half"></i>
      </div>
      <p class="font-semibold text-[13px] mt-1">Aman</p>
      <p class="text-[11px] text-gray-500 -mt-0.5">Terenkripsi</p>
      <p class="text-[11px] text-gray-500">Keamanan data terjamin</p>
    </div>

    <div class="rounded-2xl p-6 text-center bg-[#F3E6FF] shadow-sm">
      <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center mx-auto mb-2 text-white">
        <i class="bi bi-people"></i>
      </div>
      <p class="font-semibold text-[13px] mt-1">Multi</p>
      <p class="text-[11px] text-gray-500 -mt-0.5">User Access</p>
      <p class="text-[11px] text-gray-500">Akses banyak pengguna</p>
    </div>

  </div>
</div>

<!-- FEATURE CARDS -->
<div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 mt-16 px-6">

  <div class="card shadow-sm p-6">
    <div class="w-9 h-9 rounded-full bg-orange-100 text-[#FF8B00] flex items-center justify-center mb-2">
      <i class="bi bi-folder2-open"></i>
    </div>
    <p class="font-semibold text-[14px] mb-1">Kemudahan Pengarsipan Digital</p>
    <p class="text-[12px] text-gray-600">
      Sistem pengarsipan digital yang memungkinkan penyimpanan, pencarian, dan pengelolaan dokumen dengan mudah dan cepat tanpa memerlukan ruang fisik.
    </p>
  </div>

  <div class="card shadow-sm p-6">
    <div class="w-9 h-9 rounded-full bg-orange-100 text-[#FF8B00] flex items-center justify-center mb-2">
      <i class="bi bi-send"></i>
    </div>
    <p class="font-semibold text-[14px] mb-1">Efisiensi Pengelolaan Surat</p>
    <p class="text-[12px] text-gray-600">
      Otomatisasi proses surat masuk dan keluar dengan tracking real-time, notifikasi otomatis, dan workflow yang dapat disesuaikan.
    </p>
  </div>

  <div class="card shadow-sm p-6">
    <div class="w-9 h-9 rounded-full bg-orange-100 text-[#FF8B00] flex items-center justify-center mb-2">
      <i class="bi bi-list-check"></i>
    </div>
    <p class="font-semibold text-[14px] mb-1">Peningkatan Tertib Administrasi</p>
    <p class="text-[12px] text-gray-600">
      Standardisasi proses administrasi dengan template konsisten, approval workflow, dan monitoring kinerja.
    </p>
  </div>

  <div class="card shadow-sm p-6">
    <div class="w-9 h-9 rounded-full bg-orange-100 text-[#FF8B00] flex items-center justify-center mb-2">
      <i class="bi bi-lock"></i>
    </div>
    <p class="font-semibold text-[14px] mb-1">Keamanan Data Terjamin</p>
    <p class="text-[12px] text-gray-600">
      Enkripsi, backup otomatis, kontrol akses berlapis, dan audit trail untuk menjaga keamanan data instansi.
    </p>
  </div>

</div>

<!-- IMPACT -->
<div class="bg-[#FFF8F0] py-16 mt-20">
  <div class="max-w-5xl mx-auto px-6">
    <div class="bg-white border-l-4 border-yellow-500 rounded-3 shadow-sm p-6 shadow-sm">
      <p class="font-semibold text-[15px] text-center mb-1">Dampak & Nilai Tambah</p>
      <p class="text-[12px] text-gray-700 text-center leading-relaxed">
        Dengan penerapan SIANTAR, instansi dapat meningkatkan efisiensi kerja hingga 70%, mengurangi ketergantungan pada arsip fisik secara total,
        serta mendukung transformasi digital administrasi pemerintahan yang berkelanjutan.
      </p>
    </div>
  </div>
</div>

<!-- LONG TERM BENEFITS -->
<div class="text-center mt-20">
  <p class="font-bold text-lg">Manfaat Jangka Panjang</p>
  <p class="text-[12px] text-gray-600 mt-1">Investasi teknologi untuk masa depan administrasi yang lebih baik</p>
</div>

<div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8 px-6">

  <div class="rounded-2xl shadow-sm p-6 text-center bg-[#FFF2DC]">
    <div class="w-10 h-10 mx-auto rounded-full bg-[#FF8A00] flex items-center justify-center text-white mb-3">
      <i class="bi bi-arrow-repeat text-[14px]"></i>
    </div>
    <p class="font-semibold text-[13px]">Transformasi Digital</p>
    <p class="text-[11px] text-gray-500 mt-1">Mendukung transformasi digital instansi pemerintah</p>
  </div>

  <div class="rounded-2xl shadow-sm p-6 text-center bg-[#E6F0FF]">
    <div class="w-10 h-10 mx-auto rounded-full bg-[#3B82F6] flex items-center justify-center text-white mb-3">
      <i class="bi bi-shield-check text-[14px]"></i>
    </div>
    <p class="font-semibold text-[13px]">Minim Risiko</p>
    <p class="text-[11px] text-gray-500 mt-1">Meminimalkan risiko kehilangan dokumen</p>
  </div>

  <div class="rounded-2xl shadow-sm p-6 text-center bg-[#E6FFEA]">
    <div class="w-10 h-10 mx-auto rounded-full bg-[#22C55E] flex items-center justify-center text-white mb-3">
      <i class="bi bi-graph-up-arrow text-[14px]"></i>
    </div>
    <p class="font-semibold text-[13px]">Produktivitas Tinggi</p>
    <p class="text-[11px] text-gray-500 mt-1">Meningkatkan produktivitas pegawai</p>
  </div>

  <div class="rounded-2xl shadow-sm p-6 text-center bg-[#F3E6FF]">
    <div class="w-10 h-10 mx-auto rounded-full bg-[#8B5CF6] flex items-center justify-center text-white mb-3">
      <i class="bi bi-eye text-[14px]"></i>
    </div>
    <p class="font-semibold text-[13px]">Monitoring Mudah</p>
    <p class="text-[11px] text-gray-500 mt-1">Mempermudah monitoring dan evaluasi persuratan</p>
  </div>

</div>

<!-- CTA -->
<div class="text-center mt-16 mb-20">
  <p class="font-bold text-lg">Sistem Terintegrasi untuk Administrasi</p>
  <p class="font-bold text-lg -mt-1">Modern</p>
  <div class="flex justify-center gap-4 mt-4">
    <a href="{{ route('contact') }}" class="bg-orange-500 text-white text-[12px] px-6 py-2 rounded-lg flex items-center gap-2 hover:bg-orange-600 transition">
      <i class="bi bi-envelope"></i> Hubungi Admin
    </a>
    <a href="{{ route('welcome') }}#tentang" class="border border-gray-400 text-[12px] px-6 py-2 rounded-lg flex items-center gap-2 hover:bg-gray-50 transition">
      <i class="bi bi-book"></i> Pelajari SIANTAR
    </a>
  </div>
</div>

</div>
</x-app-layout>








