@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    :root{
      --orange:#FF7F00;
      --text:#1F2937;
      --muted:#6B7280;
      --line:#E5E7EB;
      --shadow: 0 8px 20px rgba(17,24,39,.10);
    }
    .card{
      border: 1px solid #EEF0F3;
      border-radius: 14px;
      background:#fff;
      box-shadow: 0 2px 12px rgba(17,24,39,.05);
    }
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
    .icon-box{
      width:44px; height:44px;
      border-radius: 12px;
      display:flex;
      align-items:center;
      justify-content:center;
      flex: 0 0 auto;
    }
    .icon-mail{ background:#EAF3FF; color:#2563EB; }
    .icon-send{ background:#E9FFF0; color:#16A34A; }
    .icon-info{ background:#F3E8FF; color:#7C3AED; }

    .left-accent{
      border-left: 4px solid var(--orange);
      padding-left: 14px;
    }
    .time{
      font-size: 12px;
      color:#9CA3AF;
      display:flex;
      align-items:center;
      gap: 8px;
      margin-top: 10px;
    }
  </style>
@endpush

<x-app-layout>
  <div class="min-h-screen bg-[#f5f7fb] text-gray-900">
    <main class="max-w-[1200px] mx-auto px-4 sm:px-6 py-6 pb-16">
      <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-3 text-sm text-gray-500 hover:text-gray-700 text-decoration-none mb-6">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Kembali</span>
      </a>

      <h1 class="text-[34px] font-bold leading-tight">Notifikasi</h1>
      <p class="text-gray-500 text-[14px] mt-2 mb-10">Daftar pemberitahuan terkait aktivitas surat dan sistem</p>

      <!-- Hari Ini -->
      <div class="mt-8">
        <div class="text-sm font-semibold text-gray-500 mb-4">Hari Ini</div>

        <div class="space-y-6">
          <!-- item 1 -->
          <div class="card p-5">
            <div class="left-accent">
              <div class="flex items-start gap-4">
                <div class="icon-box icon-mail">
                  <i class="fa-regular fa-envelope"></i>
                </div>
                <div class="flex-1">
                  <div class="text-sm font-semibold text-gray-800">Surat Masuk Baru dari Dinas Pendidikan</div>
                  <div class="text-sm text-gray-500 mt-1">
                    Surat perihal "Undangan Rapat Koordinasi Pendidikan" telah diterima dan menunggu disposisi
                  </div>
                  <div class="time"><i class="fa-regular fa-clock"></i> 2 jam yang lalu</div>
                </div>
              </div>
            </div>
          </div>

          <!-- item 2 -->
          <div class="card p-5">
            <div class="left-accent">
              <div class="flex items-start gap-4">
                <div class="icon-box icon-send">
                  <i class="fa-solid fa-paper-plane"></i>
                </div>
                <div class="flex-1">
                  <div class="text-sm font-semibold text-gray-800">Surat Keluar Telah Disetujui</div>
                  <div class="text-sm text-gray-500 mt-1">
                    Surat nomor 045/BKBP/2024 perihal "Laporan Kegiatan Bulan Januari" telah disetujui dan siap dikirim
                  </div>
                  <div class="time"><i class="fa-regular fa-clock"></i> 4 jam yang lalu</div>
                </div>
              </div>
            </div>
          </div>

          <!-- item 3 -->
          <div class="card p-5">
            <div class="left-accent">
              <div class="flex items-start gap-4">
                <div class="icon-box icon-info">
                  <i class="fa-solid fa-circle-info"></i>
                </div>
                <div class="flex-1">
                  <div class="text-sm font-semibold text-gray-800">Pemeliharaan Sistem Terjadwal</div>
                  <div class="text-sm text-gray-500 mt-1">
                    Sistem SIANTAR akan menjalani pemeliharaan rutin pada Minggu, 25 Februari 2024 pukul 00:00 - 04:00 WIB
                  </div>
                  <div class="time"><i class="fa-regular fa-clock"></i> 5 jam yang lalu</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Kemarin -->
      <div class="mt-14">
        <div class="text-sm font-semibold text-gray-500 mb-4">Kemarin</div>

        <div class="space-y-6">
          <div class="card p-6">
            <div class="flex items-start gap-4">
              <div class="icon-box icon-mail">
                <i class="fa-regular fa-envelope"></i>
              </div>
              <div class="flex-1">
                <div class="text-sm font-semibold text-gray-800">Surat Masuk dari Sekretariat Daerah</div>
                <div class="text-sm text-gray-500 mt-1">
                  Surat perihal "Permintaan Data Kegiatan" telah didisposisi ke Kepala Bidang
                </div>
                <div class="time"><i class="fa-regular fa-clock"></i> 1 hari yang lalu</div>
              </div>
            </div>
          </div>

          <div class="card p-6">
            <div class="flex items-start gap-4">
              <div class="icon-box icon-send">
                <i class="fa-solid fa-paper-plane"></i>
              </div>
              <div class="flex-1">
                <div class="text-sm font-semibold text-gray-800">Surat Keluar Berhasil Terkirim</div>
                <div class="text-sm text-gray-500 mt-1">
                  Surat nomor 043/BKBP/2024 telah terkirim ke Dinas Kesehatan
                </div>
                <div class="time"><i class="fa-regular fa-clock"></i> 1 hari yang lalu</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sebelumnya -->
      <div class="mt-14">
        <div class="text-sm font-semibold text-gray-500 mb-4">Sebelumnya</div>

        <div class="space-y-6">
          <div class="card p-6">
            <div class="flex items-start gap-4">
              <div class="icon-box icon-info">
                <i class="fa-solid fa-circle-info"></i>
              </div>
              <div class="flex-1">
                <div class="text-sm font-semibold text-gray-800">Update Sistem SIANTAR v2.1</div>
                <div class="text-sm text-gray-500 mt-1">
                  Fitur baru: Filter pencarian lanjutan dan ekspor laporan dalam format Excel telah ditambahkan
                </div>
                <div class="time"><i class="fa-regular fa-clock"></i> 3 hari yang lalu</div>
              </div>
            </div>
          </div>

          <div class="card p-6">
            <div class="flex items-start gap-4">
              <div class="icon-box icon-mail">
                <i class="fa-regular fa-envelope"></i>
              </div>
              <div class="flex-1">
                <div class="text-sm font-semibold text-gray-800">Surat Masuk dari Gubernur</div>
                <div class="text-sm text-gray-500 mt-1">
                  Surat perihal "Arahan Kebijakan 2024" telah diarsipkan
                </div>
                <div class="time"><i class="fa-regular fa-clock"></i> 5 hari yang lalu</div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</x-app-layout>