<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Kontak Kami — Final Match</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{font-family:Inter,Arial}
.card{box-shadow:0 8px 18px rgba(0,0,0,.06)}
.icon-badge{width:48px;height:48px;border-radius:999px;background:linear-gradient(180deg,#FFEED3,#FFD9AA);display:flex;align-items:center;justify-content:center;margin:0 auto 10px}
.icon-badge i{color:#FF8B00!important;font-size:18px}
.card-title{font-size:12px;font-weight:700;margin-bottom:4px}
.card-text{font-size:11px;color:#6B7280;line-height:16px}
</style>
</head>

<body class="bg-white">

@include('partials.header')

<!-- BACK BUTTON -->
<div class="max-w-7xl mx-auto px-6 mt-3">
  <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-[12px] cursor-pointer hover:text-orange-500 transition">
    <i class="fa-solid fa-arrow-left text-gray-600"></i>
    <span class="text-gray-700">Kembali</span>
  </a>
</div>

<!-- TITLE SECTION -->
<section class="text-center mt-10">
  <h1 class="text-3xl font-bold text-gray-800">Kontak Kami</h1>
  <div class="w-12 h-1 bg-orange-500 mx-auto mt-2 rounded"></div>
  <p class="text-[12px] text-gray-500 mt-2">
    Silakan hubungi kami untuk informasi lebih lanjut terkait Sistem SIANTAR
  </p>
</section>

<!-- GRAY BAND : CONTACT CARDS -->
<div class="bg-[#E5E7EB] mt-8 py-10">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-6">
    <div class="card bg-white rounded-xl border p-6 text-center">
      <div class="icon-badge"><i class="fa-solid fa-location-dot"></i></div>
      <div class="card-title">Alamat Kantor</div>
      <div class="card-text">
        Jl. Basuki Rahmat No.21, Gedong Pakuwon<br>
        Kec. Telukbetung Selatan<br>
        Kota Bandar Lampung<br>
        Lampung 35211
      </div>
    </div>
    <div class="card bg-white rounded-xl border p-6 text-center">
      <div class="icon-badge"><i class="fa-solid fa-phone"></i></div>
      <div class="card-title">Telepon</div>
      <div class="card-text">(0721) 481544</div>
    </div>
    <div class="card bg-white rounded-xl border p-6 text-center">
      <div class="icon-badge"><i class="fa-solid fa-envelope"></i></div>
      <div class="card-title">Email</div>
      <div class="card-text">kesbangpol@lampungprov.go.id</div>
    </div>
    <div class="card bg-white rounded-xl border p-6 text-center">
      <div class="icon-badge"><i class="fa-solid fa-clock"></i></div>
      <div class="card-title">Jam Operasional</div>
      <div class="card-text">Senin – Jumat<br>08.00 – 16.00 WIB</div>
    </div>
  </div>
</div>

<!-- FORM SECTION (WHITE) -->
<section class="text-center mt-10">
  <h2 class="text-xl font-semibold text-gray-800">Formulir Kontak</h2>
  <div class="w-10 h-1 bg-orange-500 mx-auto mt-1 rounded"></div>
</section>

<div class="max-w-3xl mx-auto bg-[#F3F4F6] border rounded-xl mt-4 p-8 shadow-sm">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="text-[11px] font-medium">Nama Lengkap</label>
      <input class="w-full border rounded-lg px-3 py-2 text-[12px] mt-1 bg-white">
    </div>
    <div>
      <label class="text-[11px] font-medium">Email</label>
      <input class="w-full border rounded-lg px-3 py-2 text-[12px] mt-1 bg-white">
    </div>
  </div>
  <div class="mt-3">
    <label class="text-[11px] font-medium">Subjek</label>
    <input class="w-full border rounded-lg px-3 py-2 text-[12px] mt-1 bg-white">
  </div>
  <div class="mt-3">
    <label class="text-[11px] font-medium">Pesan</label>
    <textarea class="w-full border rounded-lg px-3 py-2 text-[12px] h-32 mt-1"></textarea>
  </div>
  <div class="text-center mt-4">
    <button class="bg-orange-500 text-white text-[12px] px-6 py-2 rounded-lg">Kirim Pesan</button>
    <p class="text-[10px] text-gray-500 mt-2">Pesan Anda akan kami tindak lanjuti pada jam kerja</p>
  </div>
</div>

<!-- GRAY BAND : MAP SECTION -->
<div class="bg-[#E5E7EB] mt-10 py-10">
  <section class="text-center">
    <h2 class="text-xl font-semibold text-gray-800">Lokasi Kantor Kesbangpol</h2>
    <div class="w-10 h-1 bg-orange-500 mx-auto mt-1 rounded"></div>
  </section>

  <div class="max-w-5xl mx-auto bg-white border rounded-xl mt-4 h-64 flex items-center justify-center text-center shadow-sm overflow-hidden">
    <!-- Using Google Maps iframe instead of placeholder icon -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.207857218321!2d105.2559573147651!3d-5.419478996071068!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40da467440333d%3A0x6b77241245787627!2sBadan%20Kesatuan%20Bangsa%20dan%20Politik%20Provinsi%20Lampung!5e0!3m2!1sid!2sid!4v1646278832567!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
  </div>
</div>


<!-- TAGLINE SECTION -->
<div class="text-center text-[12px] text-gray-600 mt-6 mb-10 px-6 max-w-4xl mx-auto leading-relaxed">
  SIANTAR hadir untuk mendukung pelayanan administrasi persuratan yang lebih
  tertib, transparan, dan modern.
</div>

@include('partials.footer')

</body>
</html>