<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Pengguna — SIANTAR Kesbangpol</title>

  <!-- Tailwind (CDN) -->
  <script src="https://cdn.tailwindcss.com"></script>

<script>
  function showToast(msg){
    const t = document.getElementById('toastSuccess');
    document.getElementById('toastMsg').textContent = msg || 'Berhasil';
    t.classList.remove('hidden');
    setTimeout(hideToast, 3000);
  }
  function hideToast(){
    const t = document.getElementById('toastSuccess');
    if(t) t.classList.add('hidden');
  }
</script>


  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <!-- Font (Poppins-ish like screenshot) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root{
      --brand:#FF7F00;
      --text:#111827;
      --muted:#6B7280;
      --bg:#F3F4F6;
      --card:#FFFFFF;
      --line:#E5E7EB;
    }
    html,body{height:100%;}
    body{font-family:"Poppins",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:var(--bg);color:var(--text);}
    .shadow-soft{box-shadow:0 10px 25px rgba(17,24,39,.08);}
    .shadow-nav{box-shadow:0 3px 10px rgba(17,24,39,.10);}
    .input-like{
      background:#fff;
      border:1px solid #E5E7EB;
      border-radius:.5rem;
      height:44px;
      padding:0 14px;
      outline:none;
    }
    .input-like:focus{border-color:rgba(255,127,0,.55); box-shadow:0 0 0 4px rgba(255,127,0,.12);}
    .input-disabled{background:#fff; color:#111827;}
    .btn-outline{
      border:1.5px solid var(--brand);
      color:var(--brand);
      background:#fff;
    }
    .btn-outline:hover{background:rgba(255,127,0,.06);}
    .btn-brand{
      background:var(--brand);
      color:#fff;
    }
    .btn-brand:hover{filter:brightness(.97);}
    .footer-dark{background:#3B3B3B;}
    .divider{border-top:1px solid rgba(255,255,255,.18);}
  </style>
</head>

<body class="min-h-screen flex flex-col">

  <!-- NAVBAR -->
  <header class="bg-white shadow-nav">
    <div class="max-w-7xl mx-auto px-6">
      <div class="h-[72px] flex items-center justify-between gap-4">
        <!-- Left: logo -->
        <div class="flex items-center gap-3 min-w-[220px]">
          <div class="w-11 h-11 rounded-full bg-white flex items-center justify-center">
            <!-- If you have logo.png, replace this SVG with <img src="logo.png" class="w-11 h-11" alt="SIANTAR"> -->
            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Logo">
              <circle cx="22" cy="22" r="21" stroke="#FF7F00" stroke-width="2"/>
              <path d="M14 14.7c0-1 0.8-1.7 1.7-1.7h12.1c1 0 1.7.8 1.7 1.7V30c0 1-0.8 1.7-1.7 1.7H15.7c-1 0-1.7-0.8-1.7-1.7V14.7Z" fill="#FF7F00" opacity=".14"/>
              <path d="M18 17.5h8.8M18 21.2h8.8M18 24.9h6.8" stroke="#FF7F00" stroke-width="2" stroke-linecap="round"/>
              <path d="M30.5 16.2l2.4 2.4" stroke="#FF7F00" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </div>
          <div class="leading-tight">
            <div class="font-extrabold tracking-wide">SIANTAR</div>
            <div class="text-xs text-gray-500 -mt-0.5">Kesbangpol</div>
          </div>
        </div>

        <!-- Center: menu -->
        <nav class="hidden lg:flex items-center gap-8 text-[15px] font-medium text-gray-700">
          <a href="#" class="text-gray-700 no-underline hover:text-gray-900">Beranda</a>
          <a href="#" class="text-gray-700 no-underline hover:text-gray-900">Surat Masuk</a>
          <a href="#" class="text-gray-700 no-underline hover:text-gray-900">Surat Keluar</a>
          <a href="#" class="text-gray-700 no-underline hover:text-gray-900">Tentang</a>
          <a href="#" class="text-gray-700 no-underline hover:text-gray-900">Manfaat</a>
          <a href="#" class="text-gray-700 no-underline hover:text-gray-900">Kontak</a>
        </nav>

        <!-- Right: icons + user -->
        <div class="flex items-center justify-end gap-4 min-w-[260px]">
          <div class="relative">
            <button class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-700">
              <i class="fa-regular fa-bell"></i>
            </button>
            <span class="absolute -top-0.5 -right-0.5 w-5 h-5 rounded-full bg-[var(--brand)] text-white text-[11px] font-semibold flex items-center justify-center">3</span>
          </div>
          <button class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-700">
            <i class="fa-solid fa-gear"></i>
          </button>

          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden">
              <img src="https://images.unsplash.com/photo-1520975958221-93a62f7f9a2c?auto=format&fit=crop&w=200&q=60" alt="Foto Profil" class="w-full h-full object-cover">
            </div>
            <div class="leading-tight">
              <div class="text-sm font-semibold">Do Kyungsoo</div>
              <div class="text-xs text-gray-500">Pengguna</div>
            </div>
          </div>

          <button class="lg:hidden w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-700" aria-label="Menu">
            <i class="fa-solid fa-bars"></i>
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- CONTENT -->
  <main class="flex-1">
    <div class="max-w-7xl mx-auto px-6 py-8">
      <!-- back -->
      <a href="#" class="inline-flex items-center gap-2 text-gray-600 no-underline hover:text-gray-900 font-medium">
        <i class="fa-solid fa-arrow-left text-sm"></i>
        <span>Kembali</span>
      </a>

      <!-- title -->
      <div class="mt-10 text-center">
        <h1 class="text-[44px] leading-tight font-extrabold text-gray-900">Profil Pengguna</h1>
        <div class="flex justify-center mt-3">
          <div class="h-1 w-20 rounded-full bg-[var(--brand)]"></div>
        </div>
        <p class="mt-4 text-gray-500">Informasi akun dan data penggunaan sistem.</p>
      </div>

      <!-- cards -->
      <div class="mt-14 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- left card -->
        <section class="lg:col-span-4">
          <div class="bg-white rounded-2xl border border-gray-100 shadow-soft p-8">
            <div class="flex flex-col items-center text-center">
              <div class="relative">
                <div class="w-24 h-24 rounded-full bg-gray-200 overflow-hidden">
                  <img src="https://images.unsplash.com/photo-1520975958221-93a62f7f9a2c?auto=format&fit=crop&w=240&q=60" alt="Avatar" class="w-full h-full object-cover">
                </div>
                <button class="absolute -bottom-1 -right-1 w-9 h-9 rounded-full bg-[var(--brand)] text-white flex items-center justify-center shadow-md">
                  <i class="fa-solid fa-camera"></i>
                </button>
              </div>

              <div class="mt-4 font-semibold text-gray-900">Do Kyungsoo</div>
              <div class="text-sm text-gray-500 mt-1">Staff Kesbangpol</div>

              <button class="mt-4 inline-flex items-center gap-2 text-[var(--brand)] font-semibold hover:opacity-90">
                <i class="fa-regular fa-pen-to-square"></i>
                <span>Ubah Foto</span>
              </button>
            </div>
          </div>
        </section>

        <!-- right column -->
        <section class="lg:col-span-8 space-y-6">
          <!-- info account -->
          <div class="bg-white rounded-2xl border border-gray-100 shadow-soft overflow-hidden">
            <div class="px-6 py-5 flex items-center justify-between">
              <h2 class="font-bold text-gray-900">Informasi Akun</h2>
              <button class="btn-outline h-10 px-4 rounded-xl font-semibold inline-flex items-center gap-2">
                <i class="fa-regular fa-pen-to-square"></i>
                <span>Ubah Data</span>
              </button>
            </div>
            <div class="border-t border-gray-100 px-6 py-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                <div>
                  <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                  <input class="input-like input-disabled w-full mt-2" value="Do Kyungsoo" />
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-700">NIP / ID Pegawai</label>
                  <input class="input-like input-disabled w-full mt-2" value="198503152010011001" />
                </div>

                <div>
                  <label class="text-sm font-medium text-gray-700">Email</label>
                  <input class="input-like input-disabled w-full mt-2" value="kyungsoo.official@gmail.com" />
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-700">Username</label>
                  <input class="input-like input-disabled w-full mt-2" value="do.kyungsoo" />
                </div>

                <div>
                  <label class="text-sm font-medium text-gray-700">Unit Kerja / Bidang</label>
                  <input class="input-like input-disabled w-full mt-2" value="Bidang Kewaspadaan Nasional" />
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-700">Peran Pengguna</label>
                  <input class="input-like input-disabled w-full mt-2" value="User" />
                </div>
              </div>
            </div>
          </div>

          <!-- security -->
          <div class="bg-white rounded-2xl border border-gray-100 shadow-soft overflow-hidden">
            <div class="px-6 py-5">
              <h2 class="font-bold text-gray-900">Keamanan Akun</h2>
            </div>
            <div class="border-t border-gray-100 px-6 py-6">
              <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-9">
                  <label class="text-sm font-medium text-gray-700">Kata Sandi</label>
                  <input class="input-like w-full mt-2" type="password" value="12345678" />
                  <p class="text-xs text-gray-500 mt-2">Gunakan kata sandi yang kuat untuk menjaga keamanan akun Anda.</p>
                </div>
                <div class="md:col-span-3 md:flex md:justify-end">
                  <button class="btn-outline h-11 px-5 rounded-xl font-semibold inline-flex items-center justify-center gap-2 w-full md:w-auto">
                    <i class="fa-solid fa-key"></i>
                    <span>Ubah Kata Sandi</span>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- actions -->
          <div class="flex items-center justify-end gap-3 pt-2">
            <button class="h-11 px-6 rounded-xl border border-gray-200 bg-white text-gray-700 font-semibold hover:bg-gray-50">
              Batal
            </button>
            <button class="h-11 px-6 rounded-xl btn-brand font-semibold shadow-sm">
              <span class="inline-flex items-center gap-2">
                <i class="fa-regular fa-floppy-disk"></i>
                <span>Simpan Perubahan</span>
              </span>
            </button>
          </div>
        </section>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="footer-dark text-white mt-16">
    <div class="max-w-7xl mx-auto px-6 py-10">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
        <div class="md:col-span-4">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center">
              <svg width="34" height="34" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle cx="22" cy="22" r="21" stroke="#FF7F00" stroke-width="2"/>
                <path d="M14 14.7c0-1 0.8-1.7 1.7-1.7h12.1c1 0 1.7.8 1.7 1.7V30c0 1-0.8 1.7-1.7 1.7H15.7c-1 0-1.7-0.8-1.7-1.7V14.7Z" fill="#FF7F00" opacity=".18"/>
                <path d="M18 17.5h8.8M18 21.2h8.8M18 24.9h6.8" stroke="#FF7F00" stroke-width="2" stroke-linecap="round"/>
              </svg>
            </div>
            <div class="leading-tight">
              <div class="font-extrabold tracking-wide">SIANTAR</div>
              <div class="text-xs text-white/70 -mt-0.5">Kesbangpol</div>
            </div>
          </div>
          <p class="mt-4 text-sm text-white/70 leading-relaxed max-w-sm">
            Sistem Arsip Naskah dan Tata Persuratan untuk meningkatkan efisiensi administrasi yang efisien dan terorganisir
          </p>
        </div>

        <div class="md:col-span-2">
          <div class="font-semibold mb-3">Menu Utama</div>
          <ul class="space-y-2 text-sm text-white/70">
            <li><a href="#" class="text-white/70 no-underline hover:text-white">Beranda</a></li>
            <li><a href="#" class="text-white/70 no-underline hover:text-white">Tentang Sistem</a></li>
            <li><a href="#" class="text-white/70 no-underline hover:text-white">Manfaat</a></li>
            <li><a href="#" class="text-white/70 no-underline hover:text-white">Kontak</a></li>
          </ul>
        </div>

        <div class="md:col-span-2">
          <div class="font-semibold mb-3">Layanan</div>
          <ul class="space-y-2 text-sm text-white/70">
            <li><a href="#" class="text-white/70 no-underline hover:text-white">Surat Masuk</a></li>
            <li><a href="#" class="text-white/70 no-underline hover:text-white">Surat Keluar</a></li>
            <li><a href="#" class="text-white/70 no-underline hover:text-white">Arsip Digital</a></li>
            <li><a href="#" class="text-white/70 no-underline hover:text-white">Laporan</a></li>
          </ul>
        </div>

        <div class="md:col-span-4">
          <div class="font-semibold mb-3">Kontak Kami</div>
          <ul class="space-y-3 text-sm text-white/70">
            <li class="flex gap-3">
              <i class="fa-solid fa-location-dot mt-1 text-[var(--brand)]"></i>
              <span>Jl. Dokter Susilo No. 2, Kota Bandar Lampung</span>
            </li>
            <li class="flex items-center gap-3">
              <i class="fa-solid fa-phone text-[var(--brand)]"></i>
              <span>(0721) 476838</span>
            </li>
            <li class="flex items-center gap-3">
              <i class="fa-solid fa-envelope text-[var(--brand)]"></i>
              <span>kesbangpol@lampungprov.go.id</span>
            </li>
          </ul>
        </div>
      </div>

      <div class="divider mt-10 pt-5 text-center text-xs text-white/60">
        © 2025 SIANTAR - Badan Kesatuan Bangsa dan Politik. Hak Cipta Dilindungi.
      </div>
    </div>
  </footer>


  <!-- MODALS -->
  <!-- Backdrop helper: add/remove 'hidden' on modal root -->
  <div id="modalEditData" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="relative min-h-full flex items-center justify-center p-4">
      <div class="w-full max-w-2xl bg-white rounded-2xl shadow-soft overflow-hidden">
        <div class="px-6 py-5 flex items-center justify-between border-b border-gray-100">
          <div>
            <h3 class="font-extrabold text-gray-900">Edit Profil</h3>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi akun Anda.</p>
          </div>
          <button type="button" class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center" data-close="modalEditData" aria-label="Tutup">
            <i class="fa-solid fa-xmark text-gray-600"></i>
          </button>
        </div>

        <div class="px-6 py-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
            <div>
              <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
              <input id="edit_nama" class="input-like w-full mt-2" placeholder="Nama lengkap" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-700">NIP / ID Pegawai</label>
              <input id="edit_nip" class="input-like w-full mt-2" placeholder="NIP / ID" />
            </div>

            <div>
              <label class="text-sm font-medium text-gray-700">Email</label>
              <input id="edit_email" class="input-like w-full mt-2" placeholder="Email" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-700">Username</label>
              <input id="edit_username" class="input-like w-full mt-2" placeholder="Username" />
            </div>

            <div>
              <label class="text-sm font-medium text-gray-700">Unit Kerja / Bidang</label>
              <input id="edit_unit" class="input-like w-full mt-2" placeholder="Unit kerja / bidang" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-700">Peran Pengguna</label>
              <select id="edit_role" class="input-like w-full mt-2">
                <option>User</option>
                <option>Admin</option>
              </select>
            </div>
          </div>
        </div>

        <div class="px-6 py-5 border-t border-gray-100 flex items-center justify-end gap-3">
          <button type="button" class="h-11 px-6 rounded-xl border border-gray-200 bg-white text-gray-700 font-semibold hover:bg-gray-50" data-close="modalEditData">
            Batal
          </button>
          <button id="btnSaveEditData" type="button" class="h-11 px-6 rounded-xl btn-brand font-semibold shadow-sm">
            <span class="inline-flex items-center gap-2">
              <i class="fa-regular fa-floppy-disk"></i>
              <span>Simpan</span>
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div id="modalEditFoto" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="relative min-h-full flex items-center justify-center p-4">
      <div class="w-full max-w-xl bg-white rounded-2xl shadow-soft overflow-hidden">
        <div class="px-6 py-5 flex items-center justify-between border-b border-gray-100">
          <div>
            <h3 class="font-extrabold text-gray-900">Ubah Foto Profil</h3>
            <p class="text-sm text-gray-500 mt-1">Pilih foto baru untuk profil Anda.</p>
          </div>
          <button type="button" class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center" data-close="modalEditFoto" aria-label="Tutup">
            <i class="fa-solid fa-xmark text-gray-600"></i>
          </button>
        </div>

        <div class="px-6 py-6">
          <div class="flex items-center gap-6">
            <div class="w-24 h-24 rounded-full bg-gray-200 overflow-hidden">
              <img id="previewFoto" src="https://images.unsplash.com/photo-1520975958221-93a62f7f9a2c?auto=format&fit=crop&w=240&q=60" alt="Preview" class="w-full h-full object-cover">
            </div>
            <div class="flex-1">
              <label class="text-sm font-medium text-gray-700">Pilih Foto</label>
              <input id="inputFoto" type="file" accept="image/*" class="block w-full mt-2 text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"/>
              <p class="text-xs text-gray-500 mt-2">Format: JPG/PNG. Disarankan rasio 1:1.</p>
            </div>
          </div>
        </div>

        <div class="px-6 py-5 border-t border-gray-100 flex items-center justify-end gap-3">
          <button type="button" class="h-11 px-6 rounded-xl border border-gray-200 bg-white text-gray-700 font-semibold hover:bg-gray-50" data-close="modalEditFoto">
            Batal
          </button>
          <button id="btnSaveFoto" type="button" class="h-11 px-6 rounded-xl btn-brand font-semibold shadow-sm">
            Simpan
          </button>
        </div>
      </div>
    </div>
  </div>

  <div id="modalPassword" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="relative min-h-full flex items-center justify-center p-4">
      <div class="w-full max-w-xl bg-white rounded-2xl shadow-soft overflow-hidden">
        <div class="px-6 py-5 flex items-center justify-between border-b border-gray-100">
          <div>
            <h3 class="font-extrabold text-gray-900">Ubah Kata Sandi</h3>
            <p class="text-sm text-gray-500 mt-1">Perbarui kata sandi untuk keamanan akun.</p>
          </div>
          <button type="button" class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center" data-close="modalPassword" aria-label="Tutup">
            <i class="fa-solid fa-xmark text-gray-600"></i>
          </button>
        </div>

        <div class="px-6 py-6 space-y-4">
          <div>
            <label class="text-sm font-medium text-gray-700">Kata Sandi Lama</label>
            <input id="pw_old" type="password" class="input-like w-full mt-2" placeholder="Masukkan kata sandi lama" />
          </div>
          <div>
            <label class="text-sm font-medium text-gray-700">Kata Sandi Baru</label>
            <input id="pw_new" type="password" class="input-like w-full mt-2" placeholder="Masukkan kata sandi baru" />
          </div>
          <div>
            <label class="text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
            <input id="pw_confirm" type="password" class="input-like w-full mt-2" placeholder="Ulangi kata sandi baru" />
            <p id="pw_error" class="hidden text-xs text-red-600 mt-2">Konfirmasi kata sandi tidak sama.</p>
          </div>
        </div>

        <div class="px-6 py-5 border-t border-gray-100 flex items-center justify-end gap-3">
          <button type="button" class="h-11 px-6 rounded-xl border border-gray-200 bg-white text-gray-700 font-semibold hover:bg-gray-50" data-close="modalPassword">
            Batal
          </button>
          <button id="btnSavePassword" type="button" class="h-11 px-6 rounded-xl btn-brand font-semibold shadow-sm">
            Simpan
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // ---- Helpers
    function openModal(id){
      const el = document.getElementById(id);
      if(!el) return;
      el.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
    }
    function closeModal(id){
      const el = document.getElementById(id);
      if(!el) return;
      el.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    }

    // Close buttons
    document.querySelectorAll('[data-close]').forEach(btn=>{
      btn.addEventListener('click', ()=> closeModal(btn.getAttribute('data-close')));
    });
    // Close on backdrop click
    ['modalEditData','modalEditFoto','modalPassword'].forEach(id=>{
      const modal = document.getElementById(id);
      if(!modal) return;
      modal.addEventListener('click', (e)=>{
        if(e.target === modal) closeModal(id);
      });
      // also close if click the overlay (first child)
      const overlay = modal.querySelector(':scope > .absolute');
      if(overlay){
        overlay.addEventListener('click', ()=> closeModal(id));
      }
    });

    // ---- Wire to existing buttons (by text)
    const btnUbahData = Array.from(document.querySelectorAll('button')).find(b => b.textContent.trim().includes('Ubah Data'));
    const btnUbahFoto = Array.from(document.querySelectorAll('button')).find(b => b.textContent.trim().includes('Ubah Foto'));
    const btnUbahPassword = Array.from(document.querySelectorAll('button')).find(b => b.textContent.trim().includes('Ubah Kata Sandi'));

    // Inputs on main page (first 6 inputs inside Informasi Akun card)
    const mainInputs = {
      nama: document.querySelector('input[value="Do Kyungsoo"]'),
      nip: document.querySelector('input[value="198503152010011001"]'),
      email: document.querySelector('input[value="kyungsoo.official@gmail.com"]'),
      username: document.querySelector('input[value="do.kyungsoo"]'),
      unit: document.querySelector('input[value="Bidang Kewaspadaan Nasional"]'),
      role: document.querySelector('input[value="User"]')
    };

    // Also update small header name (top right) and card name
    const headerName = document.querySelector('header .text-sm.font-semibold');
    const cardName = Array.from(document.querySelectorAll('div')).find(d => d.classList.contains('mt-4') && d.classList.contains('font-semibold') && d.textContent.trim()==='Do Kyungsoo');

    // Photos (top right avatar + profile card avatar)
    const headerAvatar = document.querySelector('header img[alt="Foto Profil"]');
    const cardAvatar = document.querySelector('section img[alt="Avatar"]');

    if(btnUbahData){
      btnUbahData.addEventListener('click', ()=>{
        // preload modal
        document.getElementById('edit_nama').value = mainInputs.nama?.value || '';
        document.getElementById('edit_nip').value = mainInputs.nip?.value || '';
        document.getElementById('edit_email').value = mainInputs.email?.value || '';
        document.getElementById('edit_username').value = mainInputs.username?.value || '';
        document.getElementById('edit_unit').value = mainInputs.unit?.value || '';
        const roleSel = document.getElementById('edit_role');
        if(roleSel && mainInputs.role) roleSel.value = mainInputs.role.value || 'User';
        openModal('modalEditData');
      });
    }

    document.getElementById('btnSaveEditData')?.addEventListener('click', ()=>{
      if(mainInputs.nama) mainInputs.nama.value = document.getElementById('edit_nama').value;
      if(mainInputs.nip) mainInputs.nip.value = document.getElementById('edit_nip').value;
      if(mainInputs.email) mainInputs.email.value = document.getElementById('edit_email').value;
      if(mainInputs.username) mainInputs.username.value = document.getElementById('edit_username').value;
      if(mainInputs.unit) mainInputs.unit.value = document.getElementById('edit_unit').value;
      const roleVal = document.getElementById('edit_role').value;
      if(mainInputs.role) mainInputs.role.value = roleVal;

      if(headerName) headerName.textContent = document.getElementById('edit_nama').value || '—';
      if(cardName) cardName.textContent = document.getElementById('edit_nama').value || '—';
      closeModal('modalEditData'); showToast('Profil berhasil diperbarui.');
    });

    if(btnUbahFoto){
      btnUbahFoto.addEventListener('click', ()=>{
        // preload preview from current avatar
        const current = (cardAvatar && cardAvatar.src) ? cardAvatar.src : (headerAvatar ? headerAvatar.src : '');
        if(current) document.getElementById('previewFoto').src = current;
        openModal('modalEditFoto');
      });
    }

    const inputFoto = document.getElementById('inputFoto');
    inputFoto?.addEventListener('change', (e)=>{
      const file = e.target.files && e.target.files[0];
      if(!file) return;
      const url = URL.createObjectURL(file);
      document.getElementById('previewFoto').src = url;
    });

    document.getElementById('btnSaveFoto')?.addEventListener('click', ()=>{
      const src = document.getElementById('previewFoto').src;
      if(headerAvatar) headerAvatar.src = src;
      if(cardAvatar) cardAvatar.src = src;
      closeModal('modalEditFoto'); showToast('Foto profil berhasil diubah.');
    });

    if(btnUbahPassword){
      btnUbahPassword.addEventListener('click', ()=>{
        // reset
        document.getElementById('pw_old').value = '';
        document.getElementById('pw_new').value = '';
        document.getElementById('pw_confirm').value = '';
        document.getElementById('pw_error').classList.add('hidden');
        openModal('modalPassword');
      });
    }

    document.getElementById('btnSavePassword')?.addEventListener('click', ()=>{
      const nw = document.getElementById('pw_new').value;
      const cf = document.getElementById('pw_confirm').value;
      const err = document.getElementById('pw_error');
      if(nw !== cf){
        err.classList.remove('hidden');
        return;
      }
      err.classList.add('hidden');
      // Demo only: close modal (no real auth)
      closeModal('modalPassword');
      showToast('Kata sandi berhasil diperbarui.');
    });
  </script>


  <!-- TOAST SUCCESS -->
  <div id="toastSuccess" class="fixed top-8 left-1/2 -translate-x-1/2 z-[60] hidden">
    <div class="flex items-center gap-4 bg-white border border-green-300 shadow-2xl rounded-2xl px-6 py-4 min-w-[480px] max-w-[520px]">
      <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">
        <i class="fa-solid fa-check text-green-600"></i>
      </div>
      <div class="flex-1">
        <p class="font-bold text-lg text-gray-900">Berhasil</p>
        <p id="toastMsg" class="text-base text-gray-600 mt-1">Profil berhasil diperbarui.</p>
      </div>
      <button onclick="hideToast()" class="text-gray-400 hover:text-gray-600">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
  </div>

</body>
</html>
