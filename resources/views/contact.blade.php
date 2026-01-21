<x-app-layout>
  <div class="bg-white min-h-screen">

    <!-- BACK BUTTON -->
    <div class="max-w-7xl mx-auto px-6 py-4">
      <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-orange-500 transition font-medium">
        <i class="bi bi-arrow-left"></i>
        <span>Kembali</span>
      </a>
    </div>

    <!-- TITLE SECTION -->
    <section class="text-center mt-4">
      <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">Kontak Kami</h1>
      <div class="w-16 h-1 bg-orange-500 mx-auto mt-3 rounded-full"></div>
      <p class="text-gray-500 mt-4 max-w-xl mx-auto">
        Silakan hubungi kami untuk informasi lebih lanjut terkait Sistem SIANTAR
      </p>
    </section>

    <!-- CONTACT CARDS -->
    <div class="bg-gray-50 mt-10 py-12">
      <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center shadow-sm hover:shadow-md hover:border-orange-200 transition-all duration-300">
          <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
            <i class="bi bi-geo-alt-fill text-orange-500 text-xl"></i>
          </div>
          <div class="text-sm font-bold mb-2 text-gray-900">Alamat Kantor</div>
          <div class="text-sm text-gray-500 leading-relaxed">
            Jl. Dokter Susilo No. 2, Kota Bandar Lampung
          </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center shadow-sm hover:shadow-md hover:border-orange-200 transition-all duration-300">
          <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
            <i class="bi bi-telephone-fill text-orange-500 text-xl"></i>
          </div>
          <div class="text-sm font-bold mb-2 text-gray-900">Telepon</div>
          <div class="text-sm text-gray-500">(0721) 476838</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center shadow-sm hover:shadow-md hover:border-orange-200 transition-all duration-300">
          <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
            <i class="bi bi-envelope-fill text-orange-500 text-xl"></i>
          </div>
          <div class="text-sm font-bold mb-2 text-gray-900">Email</div>
          <div class="text-sm text-gray-500">kesbangpol@lampungprov.go.id</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center shadow-sm hover:shadow-md hover:border-orange-200 transition-all duration-300">
          <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
            <i class="bi bi-clock-fill text-orange-500 text-xl"></i>
          </div>
          <div class="text-sm font-bold mb-2 text-gray-900">Jam Operasional</div>
          <div class="text-sm text-gray-500">Senin - Jumat<br>08.00 - 16.00 WIB</div>
        </div>
      </div>
    </div>

    <!-- FORM SECTION -->
    <section class="py-12">
      <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Formulir Kontak</h2>
        <div class="w-12 h-1 bg-orange-500 mx-auto mt-2 rounded-full"></div>
      </div>

      <div class="max-w-3xl mx-auto bg-white border border-gray-100 rounded-2xl p-8 shadow-sm mx-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:bg-white outline-none transition" placeholder="Masukkan nama lengkap">
          </div>
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
            <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:bg-white outline-none transition" placeholder="Masukkan email">
          </div>
        </div>
        <div class="mt-5">
          <label class="block text-sm font-bold text-gray-700 mb-2">Subjek</label>
          <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:bg-white outline-none transition" placeholder="Masukkan subjek pesan">
        </div>
        <div class="mt-5">
          <label class="block text-sm font-bold text-gray-700 mb-2">Pesan</label>
          <textarea class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:bg-white outline-none transition h-32 resize-none" placeholder="Tuliskan pesan Anda..."></textarea>
        </div>
        <div class="text-center mt-6">
          <button class="inline-flex items-center justify-center px-8 py-3 bg-orange-500 text-white font-bold rounded-xl shadow-orange hover:bg-orange-600 transition duration-200">
            <i class="bi bi-send-fill mr-2"></i> Kirim Pesan
          </button>
          <p class="text-sm text-gray-500 mt-3">Pesan Anda akan kami tindak lanjuti pada jam kerja</p>
        </div>
      </div>
    </section>

    <!-- MAP SECTION -->
    <div class="bg-gray-50 py-12">
      <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Lokasi Kantor Kesbangpol</h2>
        <div class="w-12 h-1 bg-orange-500 mx-auto mt-2 rounded-full"></div>
      </div>

      <div class="max-w-5xl mx-auto px-6">
        <div class="bg-white border border-gray-100 rounded-2xl h-72 shadow-sm overflow-hidden">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.207857218321!2d105.2559573147651!3d-5.419478996071068!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40da467440333d%3A0x6b77241245787627!2sBadan%20Kesatuan%20Bangsa%20dan%20Politik%20Provinsi%20Lampung!5e0!3m2!1sid!2sid!4v1646278832567!5m2!1sid!2sid" width="100%" height="100%" class="border-0" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
    </div>

    <!-- TAGLINE SECTION -->
    <div class="text-center text-gray-600 py-10 px-6 max-w-4xl mx-auto">
      <p class="text-lg font-medium">
        SIANTAR hadir untuk mendukung pelayanan administrasi persuratan yang lebih tertib, transparan, dan modern.
      </p>
    </div>

  </div>
</x-app-layout>
