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

      @php
      $sections = [
        'today' => 'Hari Ini',
        'yesterday' => 'Kemarin',
        'older' => 'Sebelumnya',
      ];
      $iconMap = [
        'mail' => ['icon' => 'fa-regular fa-envelope', 'box' => 'icon-mail'],
        'send' => ['icon' => 'fa-solid fa-paper-plane', 'box' => 'icon-send'],
        'info' => ['icon' => 'fa-solid fa-circle-info', 'box' => 'icon-info'],
      ];
      $totalNotifications = collect($groupedNotifications)->flatten()->count();
      @endphp

      @if ($totalNotifications === 0)
        <div class="card p-8 text-center text-gray-500">
          Belum ada notifikasi.
        </div>
      @else
        @foreach ($sections as $key => $label)
          @php
          $items = $groupedNotifications[$key] ?? [];
          @endphp
          @if (count($items) > 0)
            <div class="{{ $key === 'today' ? 'mt-8' : 'mt-14' }}">
              <div class="text-sm font-semibold text-gray-500 mb-4">{{ $label }}</div>
              <div class="space-y-6">
                @foreach ($items as $notification)
                  @php
                  $data = $notification->data ?? [];
                  $iconKey = $data['icon'] ?? 'info';
                  $icon = $iconMap[$iconKey]['icon'] ?? $iconMap['info']['icon'];
                  $iconBox = $iconMap[$iconKey]['box'] ?? $iconMap['info']['box'];
                  $createdAt = $notification->created_at
                    ? \Illuminate\Support\Carbon::parse($notification->created_at)
                    : null;
                  $timeLabel = $createdAt ? $createdAt->diffForHumans() : '-';
                  $url = $data['url'] ?? null;
                  @endphp
                  <div class="card p-5">
                    <div class="left-accent">
                      <div class="flex items-start gap-4">
                        <div class="icon-box {{ $iconBox }}">
                          <i class="{{ $icon }}"></i>
                        </div>
                        <div class="flex-1">
                          <div class="text-sm font-semibold text-gray-800">
                            {{ $data['title'] ?? 'Notifikasi' }}
                          </div>
                          <div class="text-sm text-gray-500 mt-1">
                            {{ $data['message'] ?? '-' }}
                          </div>
                          @if ($url)
                            <a href="{{ $url }}" class="text-sm text-orange-500 mt-2 inline-block">Lihat detail</a>
                          @endif
                          <div class="time"><i class="fa-regular fa-clock"></i> {{ $timeLabel }}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif
        @endforeach
      @endif

    </main>
  </div>
</x-app-layout>
