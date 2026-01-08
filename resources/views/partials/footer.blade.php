<footer class="bg-[#272421]/90 text-gray-200 px-10 py-10">
  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10">
    <div>
      <div class="flex items-center gap-2 mb-2">
        <img src="{{ asset('image/logo.png') }}" class="w-8">
        <div class="leading-tight">
          <span class="text-sm font-semibold text-white">SIANTAR</span><br>
          <span class="text-[11px] text-gray-300">Kesbangpol</span>
        </div>
      </div>
      <p class="text-[11px] text-gray-300 leading-relaxed">
        Sistem Arsip Naskah dan Tata<br>
        Persuratan untuk meningkatkan<br>
        efisiensi administrasi yang efisien dan<br>
        terorganisir
      </p>
    </div>
    <div>
      <p class="text-[12px] font-bold mb-1 text-white">Menu Utama</p>
      <a href="{{ route('welcome') }}" class="text-[11px] block hover:text-orange-500 text-gray-300 text-decoration-none">Beranda</a>
      <a href="{{ route('tentang') }}" class="text-[11px] block hover:text-orange-500 text-gray-300 text-decoration-none">Tentang Sistem</a>
      <a href="{{ route('manfaat') }}" class="text-[11px] block hover:text-orange-500 text-gray-300 text-decoration-none">Manfaat</a>
      <a href="{{ route('contact') }}" class="text-[11px] block hover:text-orange-500 text-gray-300 text-decoration-none">Kontak</a>
    </div>
    <div>
      <p class="text-[12px] font-bold mb-1 text-white">Layanan</p>
      <p class="text-[11px]">Surat Masuk</p>
      <p class="text-[11px]">Surat Keluar</p>
      <p class="text-[11px]">Arsip Digital</p>
      <p class="text-[11px]">Laporan</p>
    </div>
    <div>
      <p class="text-[12px] font-bold mb-1 text-white">Kontak Kami</p>
      <p class="text-[11px] flex gap-2"><i class="bi bi-geo-alt-fill text-orange-500 mt-0.5"></i>Jl. Dokter Susilo No. 2, Kota Bandar Lampung</p>
      <p class="text-[11px] flex gap-2 mt-1"><i class="bi bi-telephone-fill text-orange-500"></i>(0721) 481544</p>
      <p class="text-[11px] flex gap-2 mt-1"><i class="bi bi-envelope-fill text-orange-500"></i>kesbangpol@lampungprov.go.id</p>
    </div>
  </div>
  <div class="h-px bg-gray-400/40 mt-5 mb-3"></div>
  <p class="text-center text-[10px] text-gray-300">
    © 2025 SIANTAR - Badan Kesatuan Bangsa dan Politik. Hak Cipta Dilindungi.
  </p>
</footer>
