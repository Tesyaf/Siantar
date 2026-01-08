@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    :root{
      --orange:#FF7F00;
      --text:#1F2937;
      --muted:#6B7280;
      --line:#E5E7EB;
      --card:#FFFFFF;
      --bg:#F7F8FA;
      --shadow: 0 8px 20px rgba(17,24,39,.10);
    }
    .soft-card{ background: var(--card); border: 1px solid #EEF0F3; box-shadow: 0 2px 10px rgba(17,24,39,.05); border-radius: 14px; }
    .section-card{ border: 1px solid #EEF0F3; border-radius: 14px; overflow: hidden; background: #fff; }
    .section-head{ padding: 18px 20px; display:flex; align-items:center; justify-content:space-between; cursor:pointer; }
    .section-head:hover{ background: #FBFBFC; }
    .section-body{ padding: 0 20px 18px 20px; }
    .pill-icon{
      width:44px; height:44px; border-radius: 12px;
      background: rgba(255,127,0,.12);
      display:flex; align-items:center; justify-content:center;
      color: var(--orange);
      flex: 0 0 auto;
    }
    .orange-bar{ width:4px; height:40px; background: var(--orange); border-radius: 4px; }
    .btn-orange{
      background: var(--orange);
      color: #fff;
      border-radius: 10px;
      padding: 10px 18px;
      font-weight: 600;
      box-shadow: 0 6px 14px rgba(255,127,0,.28);
    }
    .btn-orange:hover{ filter: brightness(.98); }
    .btn-outline{
      background:#fff;
      border: 1px solid #D1D5DB;
      border-radius: 10px;
      padding: 10px 18px;
      font-weight: 500;
      color: #374151;
      box-shadow: 0 4px 10px rgba(17,24,39,.06);
    }
    .btn-outline:hover{ background:#FAFAFB; }
    .badge-orange{
      background: var(--orange);
      color:#fff;
      font-size: 11px;
      width: 18px;
      height: 18px;
      border-radius: 999px;
      display:flex;
      align-items:center;
      justify-content:center;
      position:absolute;
      top:-7px;
      right:-7px;
      border: 2px solid #fff;
    }

    /* Custom form */
    .select-like, .input-like{
      width: 100%;
      border: 1px solid #E5E7EB;
      border-radius: 10px;
      padding: 10px 42px 10px 14px;
      background: #fff;
      color: #374151;
      outline: none;
    }
    .input-like{ padding-right: 46px; }
    .select-wrap, .input-wrap{
      position: relative;
    }
    .select-wrap i.chev, .input-wrap i.eye{
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #9CA3AF;
      pointer-events: none;
    }
    .input-wrap button.eye-btn{
      position:absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      width: 34px;
      height: 34px;
      border-radius: 10px;
      display:flex;
      align-items:center;
      justify-content:center;
      color: #9CA3AF;
      background: transparent;
    }
    .input-wrap button.eye-btn:hover{ background: #F3F4F6; }

    /* Toggle */
    .toggle{
      width: 44px; height: 24px;
      border-radius: 999px;
      background: #D1D5DB;
      position: relative;
      transition: all .2s ease;
      flex: 0 0 auto;
    }
    .toggle::after{
      content:"";
      width: 18px; height: 18px;
      border-radius: 999px;
      background: #fff;
      position:absolute;
      top: 3px;
      left: 3px;
      transition: all .2s ease;
      box-shadow: 0 2px 6px rgba(17,24,39,.18);
    }
    .toggle[data-on="true"]{
      background: var(--orange);
    }
    .toggle[data-on="true"]::after{
      left: 23px;
    }

    /* Info box */
    .info{
      border: 1px solid #CFE3FF;
      background: #EEF6FF;
      color: #1D4ED8;
      border-radius: 10px;
      padding: 10px 12px;
      display:flex;
      gap: 10px;
      align-items:flex-start;
      font-size: 12px;
    }

    /* Accordion caret */
    .caret{
      width: 34px; height: 34px;
      border-radius: 10px;
      display:flex; align-items:center; justify-content:center;
      color: #9CA3AF;
    }
    .caret:hover{ background:#F3F4F6; }
    .hidden-body{ display:none; }
  
    .icon-box{
      width:56px;
      height:56px;
      border-radius:16px;
      background:#FFF1E6;
      display:flex;
      align-items:center;
      justify-content:center;
      color:#FF7F00;
      font-size:22px;
      flex-shrink:0;
    }

  </style>
@endpush

<x-app-layout>
  <div class="min-h-screen bg-[#f5f7fb] text-gray-900">
    <main class="max-w-[1200px] mx-auto px-4 sm:px-6 py-6 pb-16">
      <!-- back -->
      <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-3 text-sm text-gray-500 hover:text-gray-700 text-decoration-none">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Kembali</span>
      </a>

      <!-- Title -->
      <div class="mt-8 flex items-start gap-5">
        <div class="orange-bar mt-1"></div>
        <div>
          <h1 class="text-[34px] font-bold leading-tight">Pengaturan Akun</h1>
          <p class="text-gray-500 text-[14px] mt-1">Atur preferensi akun, keamanan, dan notifikasi Anda.</p>
        </div>
      </div>

      <!-- Settings card -->
      <div class="mt-9 soft-card p-0 max-w-[980px]">
        <!-- Preferensi Umum -->
        <section class="section-card m-6" data-accordion="true" data-open="true">
          <div class="section-head">
            <div class="flex items-center gap-14">
              <div class="flex items-center gap-4">
                <div class="icon-box">
                  <i class="fa-solid fa-gear"></i>
                </div>
                <div class="font-semibold">Preferensi Umum</div>
              </div>
            </div>
            <div class="caret"><i class="fa-solid fa-chevron-up"></i></div>
          </div>

          <div class="section-body">
            <div class="grid md:grid-cols-2 gap-6">
              <div>
                <div class="text-xs text-gray-500 mb-2">Bahasa Sistem</div>
                <div class="select-wrap">
                  <select class="select-like appearance-none">
                    <option selected>Bahasa Indonesia</option>
                    <option>English</option>
                  </select>
                  <i class="fa-solid fa-chevron-down chev"></i>
                </div>
              </div>
              <div>
                <div class="text-xs text-gray-500 mb-2">Zona Waktu</div>
                <div class="select-wrap">
                  <select class="select-like appearance-none">
                    <option selected>WIB (Waktu Indonesia Barat)</option>
                    <option>WITA (Waktu Indonesia Tengah)</option>
                    <option>WIT (Waktu Indonesia Timur)</option>
                  </select>
                  <i class="fa-solid fa-chevron-down chev"></i>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Keamanan Akun -->
        <section class="section-card mx-6 mb-6" data-accordion="true" data-open="true">
          <div class="section-head">
            <div class="flex items-center gap-4">
              <div class="icon-box">
                <i class="fa-solid fa-shield-halved"></i>
              </div>
              <div class="font-semibold">Keamanan Akun</div>
            </div>
            <div class="caret"><i class="fa-solid fa-chevron-up"></i></div>
          </div>

          <div class="section-body">
            <div class="text-sm font-semibold text-gray-700 mt-2">Ubah Kata Sandi</div>

            <div class="mt-4 space-y-4">
              <div>
                <div class="text-xs text-gray-500 mb-2">Kata Sandi Lama</div>
                <div class="input-wrap">
                  <input type="password" class="input-like" placeholder="Masukkan kata sandi lama" />
                  <button class="eye-btn" type="button" onclick="togglePass(this)"><i class="fa-regular fa-eye"></i></button>
                </div>
              </div>

              <div>
                <div class="text-xs text-gray-500 mb-2">Kata Sandi Baru</div>
                <div class="input-wrap">
                  <input type="password" class="input-like" placeholder="Masukkan kata sandi baru" />
                  <button class="eye-btn" type="button" onclick="togglePass(this)"><i class="fa-regular fa-eye"></i></button>
                </div>
              </div>

              <div>
                <div class="text-xs text-gray-500 mb-2">Konfirmasi Kata Sandi Baru</div>
                <div class="input-wrap">
                  <input type="password" class="input-like" placeholder="Ulangi kata sandi baru" />
                  <button class="eye-btn" type="button" onclick="togglePass(this)"><i class="fa-regular fa-eye"></i></button>
                </div>
              </div>

              <div class="text-[11px] text-gray-500 flex items-center gap-2">
                <i class="fa-regular fa-circle-question text-gray-400"></i>
                Gunakan minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, dan angka.
              </div>

              <button class="btn-orange mt-1" type="button">Perbarui Kata Sandi</button>
            </div>
          </div>
        </section>

        <!-- Notifikasi -->
        <section class="section-card mx-6 mb-6" data-accordion="true" data-open="true">
          <div class="section-head">
            <div class="flex items-center gap-4">
              <div class="icon-box">
                <i class="fa-solid fa-bell"></i>
              </div>
              <div class="font-semibold">Notifikasi</div>
            </div>
            <div class="caret"><i class="fa-solid fa-chevron-up"></i></div>
          </div>

          <div class="section-body">
            <div class="divide-y divide-gray-100 rounded-xl overflow-hidden border border-gray-100">
              <div class="flex items-center justify-between py-4 px-4">
                <div>
                  <div class="text-sm font-semibold text-gray-700">Notifikasi Surat Masuk</div>
                  <div class="text-xs text-gray-500 mt-1">Pemberitahuan saat surat masuk baru diterima</div>
                </div>
                <button class="toggle" data-on="true" type="button" onclick="toggleSwitch(this)"></button>
              </div>

              <div class="flex items-center justify-between py-4 px-4">
                <div>
                  <div class="text-sm font-semibold text-gray-700">Notifikasi Surat Keluar</div>
                  <div class="text-xs text-gray-500 mt-1">Pemberitahuan saat surat keluar dikirim</div>
                </div>
                <button class="toggle" data-on="true" type="button" onclick="toggleSwitch(this)"></button>
              </div>

              <div class="flex items-center justify-between py-4 px-4">
                <div>
                  <div class="text-sm font-semibold text-gray-700">Notifikasi Perubahan Status Surat</div>
                  <div class="text-xs text-gray-500 mt-1">Pemberitahuan ketika status surat berubah</div>
                </div>
                <button class="toggle" data-on="false" type="button" onclick="toggleSwitch(this)"></button>
              </div>

              <div class="flex items-center justify-between py-4 px-4">
                <div>
                  <div class="text-sm font-semibold text-gray-700">Notifikasi Sistem</div>
                  <div class="text-xs text-gray-500 mt-1">Pemberitahuan terkait pembaruan atau informasi sistem</div>
                </div>
                <button class="toggle" data-on="true" type="button" onclick="toggleSwitch(this)"></button>
              </div>
            </div>

            <div class="info mt-4">
              <i class="fa-solid fa-circle-info mt-[2px]"></i>
              <div>Pengaturan ini membantu Anda memilih jenis notifikasi yang ingin diterima.</div>
            </div>
          </div>
        </section>

        <!-- Privasi -->
        <section class="section-card mx-6 mb-6" data-accordion="true" data-open="true">
          <div class="section-head">
            <div class="flex items-center gap-4">
              <div class="icon-box">
                <i class="fa-solid fa-user-shield"></i>
              </div>
              <div class="font-semibold">Privasi</div>
            </div>
            <div class="caret"><i class="fa-solid fa-chevron-up"></i></div>
          </div>

          <div class="section-body">
            <div class="divide-y divide-gray-100 rounded-xl overflow-hidden border border-gray-100">
              <div class="flex items-center justify-between py-4 px-4">
                <div>
                  <div class="text-sm font-semibold text-gray-700">Tampilkan Nama Lengkap</div>
                  <div class="text-xs text-gray-500 mt-1">Nama lengkap Anda dapat dilihat oleh pengguna lain dalam sistem</div>
                </div>
                <button class="toggle" data-on="true" type="button" onclick="toggleSwitch(this)"></button>
              </div>

              <div class="flex items-center justify-between py-4 px-4">
                <div>
                  <div class="text-sm font-semibold text-gray-700">Tampilkan Email</div>
                  <div class="text-xs text-gray-500 mt-1">Alamat email ditampilkan pada informasi akun</div>
                </div>
                <button class="toggle" data-on="false" type="button" onclick="toggleSwitch(this)"></button>
              </div>

              <div class="flex items-center justify-between py-4 px-4">
                <div>
                  <div class="text-sm font-semibold text-gray-700">Tampilkan Unit Kerja</div>
                  <div class="text-xs text-gray-500 mt-1">Unit kerja ditampilkan pada profil pengguna</div>
                </div>
                <button class="toggle" data-on="true" type="button" onclick="toggleSwitch(this)"></button>
              </div>

              <div class="flex items-center justify-between py-4 px-4">
                <div>
                  <div class="text-sm font-semibold text-gray-700">Izinkan Notifikasi Email</div>
                  <div class="text-xs text-gray-500 mt-1">Menerima notifikasi sistem melalui email</div>
                </div>
                <button class="toggle" data-on="true" type="button" onclick="toggleSwitch(this)"></button>
              </div>
            </div>

            <div class="info mt-4">
              <i class="fa-solid fa-circle-info mt-[2px]"></i>
              <div>Pengaturan privasi membantu Anda mengontrol informasi pribadi yang ditampilkan pada sistem.</div>
            </div>
          </div>
        </section>

        <!-- Action buttons -->
        <div class="px-6 pb-6">
          <div class="border-t border-gray-200 pt-5 flex items-center justify-end gap-4">
            <button class="btn-outline" type="button">Batal</button>
            <button class="btn-orange" type="button">Simpan Perubahan</button>
          </div>
        </div>
      </div>
    </div>
  </main>

  @push('scripts')
  <script>
    // Accordion
    document.querySelectorAll('[data-accordion="true"]').forEach((sec) => {
      const head = sec.querySelector('.section-head');
      const body = sec.querySelector('.section-body');
      const icon = sec.querySelector('.caret i');

      const setOpen = (open) => {
        sec.dataset.open = open ? "true" : "false";
        body.style.display = open ? "block" : "none";
        icon.classList.toggle('fa-chevron-up', open);
        icon.classList.toggle('fa-chevron-down', !open);
      };

      // init
      setOpen(sec.dataset.open === "true");

      head.addEventListener('click', (e) => {
        // prevent when clicking inputs inside head (none here, but safe)
        const open = sec.dataset.open === "true";
        setOpen(!open);
      });
    });

    // Toggle switch
    function toggleSwitch(btn){
      const on = btn.getAttribute('data-on') === 'true';
      btn.setAttribute('data-on', (!on).toString());
    }

    // Password visibility
    function togglePass(btn){
      const wrap = btn.closest('.input-wrap');
      const input = wrap.querySelector('input');
      const icon = btn.querySelector('i');
      const isPass = input.type === 'password';
      input.type = isPass ? 'text' : 'password';
      icon.classList.toggle('fa-eye', !isPass);
      icon.classList.toggle('fa-eye-slash', isPass);
    }
  </script>
  @endpush
</x-app-layout>