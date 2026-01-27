<footer class="bg-gray-900 text-gray-300 px-6 lg:px-10 py-12">
  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10">
    <div>
      <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 rounded-xl bg-orange-500/20 flex items-center justify-center">
          <img src="{{ asset('image/logo.png') }}" class="w-6">
        </div>
        <div class="leading-tight">
          <span class="text-base font-bold text-white">SIANTAR</span><br>
          <span class="text-[11px] text-gray-400">Kesbangpol</span>
        </div>
      </div>
      <p class="text-[12px] text-gray-400 leading-relaxed">
        Sistem Arsip Naskah dan Tata Persuratan untuk meningkatkan efisiensi administrasi yang efisien dan terorganisir
      </p>
    </div>
    <div>
      <p class="text-[13px] font-bold mb-4 text-white">Menu Utama</p>
      <div class="space-y-2">
        <a href="{{ route('welcome') }}" class="text-[12px] block hover:text-orange-400 text-gray-400 text-decoration-none transition-colors">Beranda</a>
        <a href="{{ route('tentang') }}" class="text-[12px] block hover:text-orange-400 text-gray-400 text-decoration-none transition-colors">Tentang Sistem</a>
        <a href="{{ route('manfaat') }}" class="text-[12px] block hover:text-orange-400 text-gray-400 text-decoration-none transition-colors">Manfaat</a>
        <a href="{{ route('contact') }}" class="text-[12px] block hover:text-orange-400 text-gray-400 text-decoration-none transition-colors">Kontak</a>
      </div>
    </div>
    <div>
      <p class="text-[13px] font-bold mb-4 text-white">Layanan</p>
      <div class="space-y-2">
        <p class="text-[12px] text-gray-400">Surat Masuk</p>
        <p class="text-[12px] text-gray-400">Surat Keluar</p>
        <p class="text-[12px] text-gray-400">Arsip Digital</p>
        <p class="text-[12px] text-gray-400">Laporan</p>
      </div>
    </div>
    <div>
      <p class="text-[13px] font-bold mb-4 text-white">Kontak Kami</p>
      <div class="space-y-3">
        <p class="text-[12px] flex gap-3 text-gray-400">
          <i class="bi bi-geo-alt-fill text-orange-400 mt-0.5"></i>
          <span>Jl. Dokter Susilo No. 2, Kota Bandar Lampung</span>
        </p>
        <p class="text-[12px] flex gap-3 text-gray-400">
          <i class="bi bi-telephone-fill text-orange-400"></i>
          <span>(0721) 476838</span>
        </p>
        <p class="text-[12px] flex gap-3 text-gray-400">
          <i class="bi bi-envelope-fill text-orange-400"></i>
          <span>kesbangpol@lampungprov.go.id</span>
        </p>
      </div>
    </div>
  </div>
  <div class="h-px bg-gray-700 mt-8 mb-6"></div>
  <p class="text-center text-[11px] text-gray-500">
    © {{ date('Y') }} SIANTAR - Badan Kesatuan Bangsa dan Politik. Hak Cipta Dilindungi.
  </p>
</footer>
