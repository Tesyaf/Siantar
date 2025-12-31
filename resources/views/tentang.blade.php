<x-guest-layout>
    @include('partials.header')

    <!-- BACK -->
    <div class="max-w-7xl mx-auto px-6 py-4 text-[12px] flex items-center gap-2">
      <a href="{{ route('welcome') }}" class="inline-flex items-center gap-2 hover:text-orange-500 transition cursor-pointer">
        <i class="fa-solid fa-arrow-left text-gray-600"></i> <span class="text-gray-700">Kembali</span>
      </a>
    </div>

    <!-- HEADING -->
    <div class="text-center mt-2">
      <h1 class="text-[22px] md:text-[26px] font-extrabold text-[#0F172A] tracking-tight">
        Tentang Sistem SIANTAR
      </h1>
      <div class="w-16 h-[3px] bg-[#F97316] rounded-full mx-auto mt-2"></div>
      <p class="text-[12px] text-gray-600 mt-3 max-w-xl mx-auto leading-snug">
        Solusi digital untuk modernisasi tata kelola persuratan dan pengarsipan naskah di
        lingkungan Badan Kesatuan Bangsa dan Politik
      </p>
    </div>

    <!-- DESCRIPTION SECTION -->
    <div class="bg-gray-50 py-12 mt-10">
        <div class="max-w-5xl mx-auto px-6">
          <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6 text-[13px] leading-relaxed text-gray-700">
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
      <p class="font-bold text-lg">Fitur Utama Sistem</p>
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 px-6">

      <div class="bg-[#FFF4E5] rounded-2xl p-6 text-center border shadow">
        <div class="w-10 h-10 mx-auto rounded-full bg-orange-500 flex items-center justify-center text-white mb-2">
          <i class="fa-solid fa-inbox"></i>
        </div>
        <p class="font-semibold text-[13px]">Surat Masuk</p>
        <p class="text-[11px] text-gray-600 mt-1">
          Pendaftaran dan pelacakan surat masuk secara digital with dukungan sistem disposisi serta pemantauan status surat secara real-time.
        </p>
      </div>

      <div class="bg-[#FFF4E5] rounded-2xl p-6 text-center border shadow">
        <div class="w-10 h-10 mx-auto rounded-full bg-orange-500 flex items-center justify-center text-white mb-2">
          <i class="fa-solid fa-paper-plane"></i>
        </div>
        <p class="font-semibold text-[13px]">Surat Keluar</p>
        <p class="text-[11px] text-gray-600 mt-1">
          Pembuatan dan pengiriman surat keluar dengan alur persetujuan bertingkat serta fitur pemantauan status pengiriman surat.
        </p>
      </div>

      <div class="bg-[#FFF4E5] rounded-2xl p-6 text-center border shadow">
        <div class="w-10 h-10 mx-auto rounded-full bg-orange-500 flex items-center justify-center text-white mb-2">
          <i class="fa-solid fa-box-archive"></i>
        </div>
        <p class="font-semibold text-[13px]">Arsip Digital</p>
        <p class="text-[11px] text-gray-600 mt-1">
          Penyimpanan arsip naskah secara terstruktur dengan sistem pencarian cepat, aman, dan mudah diakses.
        </p>
      </div>

    </div>

    <!-- TUJUAN SECTION -->
    <div class="bg-gray-50 py-12 mt-16">
        <div class="max-w-5xl mx-auto px-6">
          <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6 text-center">
            <div class="w-10 h-10 mx-auto rounded-full bg-orange-500 flex items-center justify-center text-white mb-2">
              <i class="fa-solid fa-bullseye"></i>
            </div>
            <p class="font-bold text-[14px] mb-1">Tujuan Sistem</p>
            <p class="text-[12px] text-gray-600 leading-relaxed">
              SIANTAR dikembangkan untuk mendukung modernisasi tata kelola persuratan, mengurangi penggunaan arsip fisik,
              serta meningkatkan transparansi dan akuntabilitas dalam pengelolaan dokumen.
            </p>
          </div>
        </div>
    </div>

    <!-- MANFAAT SISTEM -->
    <div class="text-center mt-16">
      <h2 class="text-[18px] md:text-[20px] font-extrabold text-[#0F172A] tracking-tight">
        Manfaat Sistem
      </h2>
    </div>

    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-10 mt-8 mb-20 px-6">

      <div class="flex gap-3">
        <div class="w-7 h-7 rounded-lg bg-[#FFF4E5] flex items-center justify-center">
          <i class="fa-solid fa-clock text-[#F59E0B] text-[12px]"></i>
        </div>
        <div>
          <p class="font-semibold text-[13px]">Efisiensi Waktu</p>
          <p class="text-[11px] text-gray-600 -mt-0.5">
            Mempercepat proses administrasi dan pengelolaan dokumen
          </p>
        </div>
      </div>

      <div class="flex gap-3">
        <div class="w-7 h-7 rounded-lg bg-[#FFF4E5] flex items-center justify-center">
          <i class="fa-solid fa-shield-halved text-[#F59E0B] text-[12px]"></i>
        </div>
        <div>
          <p class="font-semibold text-[13px]">Keamanan Data</p>
          <p class="text-[11px] text-gray-600 -mt-0.5">
            Sistem keamanan berlapis untuk melindungi dokumen penting
          </p>
        </div>
      </div>

      <div class="flex gap-3">
        <div class="w-7 h-7 rounded-lg bg-[#FFF4E5] flex items-center justify-center">
          <i class="fa-solid fa-magnifying-glass text-[#F59E0B] text-[12px]"></i>
        </div>
        <div>
          <p class="font-semibold text-[13px]">Pencarian Mudah</p>
          <p class="text-[11px] text-gray-600 -mt-0.5">
            Fitur pencarian canggih untuk menemukan dokumen dengan cepat
          </p>
        </div>
      </div>

      <div class="flex gap-3">
        <div class="w-7 h-7 rounded-lg bg-[#FFF4E5] flex items-center justify-center">
          <i class="fa-solid fa-scale-balanced text-[#F59E0B] text-[12px]"></i>
        </div>
        <div>
          <p class="font-semibold text-[13px]">Transparansi</p>
          <p class="text-[11px] text-gray-600 -mt-0.5">
            Meningkatkan akuntabilitas dalam pengelolaan persuratan
          </p>
        </div>
      </div>

    </div>

    @include('partials.footer')
</x-guest-layout>