<header class="bg-white border-b sticky top-0 z-50">
  <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-3 text-[12px]">
    <a href="{{ route('welcome') }}" class="flex items-center gap-2 text-decoration-none">
      <img src="{{ asset('image/logo.png') }}" class="w-9 h-9">
      <div class="leading-tight">
        <span class="font-semibold text-gray-800 text-sm">SIANTAR</span><br>
        <span class="text-[11px] text-gray-500 -mt-1">Kesbangpol</span>
      </div>
    </a>
    <nav class="flex gap-6 text-gray-700">
      @auth
        @php
          $canInputLetter = Auth::user()->hasAnyRole(['sekretariat', 'admin']);
        @endphp
        <a href="{{ route('dashboard') }}" class="text-gray-700 text-decoration-none hover:text-orange-500 {{ request()->routeIs('dashboard') ? 'font-bold text-orange-500' : '' }}">Beranda</a>
        <a href="{{ route('surat-masuk.index') }}" class="text-gray-700 text-decoration-none hover:text-orange-500 {{ request()->routeIs('surat-masuk.index') ? 'font-bold text-orange-500' : '' }}">Surat Masuk</a>
        <a href="{{ route('surat-keluar.index') }}" class="text-gray-700 text-decoration-none hover:text-orange-500 {{ request()->routeIs('surat-keluar.index') ? 'font-bold text-orange-500' : '' }}">Surat Keluar</a>
        <a href="{{ route('cari-arsip') }}" class="text-gray-700 text-decoration-none hover:text-orange-500 {{ request()->routeIs('cari-arsip') ? 'font-bold text-orange-500' : '' }}">Arsip Digital</a>
        @if ($canInputLetter)
          <a href="{{ route('tambah-surat') }}" class="text-gray-700 text-decoration-none hover:text-orange-500 {{ request()->routeIs('tambah-surat') ? 'font-bold text-orange-500' : '' }}">Tambah Surat</a>
        @endif
      @else
        <a href="{{ route('tentang') }}" class="text-gray-700 text-decoration-none hover:text-orange-500 {{ request()->routeIs('tentang') ? 'font-bold text-orange-500' : '' }}">Tentang</a>
        <a href="{{ route('manfaat') }}" class="text-gray-700 text-decoration-none hover:text-orange-500 {{ request()->routeIs('manfaat') ? 'font-bold text-orange-500' : '' }}">Manfaat</a>
        <a href="{{ route('contact') }}" class="text-gray-700 text-decoration-none hover:text-orange-500 {{ request()->routeIs('contact') ? 'font-bold text-orange-500' : 'font-semibold' }}">Kontak</a>
      @endauth
    </nav>
    <div class="flex items-center gap-4">
      @auth
        <div class="relative">
            <i class="bi bi-bell text-gray-700"></i>
            <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-[10px] rounded-full px-1.5">3</span>
        </div>
        <a href="{{ route('dashboard') }}" class="text-gray-700 text-decoration-none hover:text-orange-500">
            <i class="bi bi-gear text-gray-700"></i>
        </a>
        <div class="flex items-center gap-2">
            <!-- Placeholder avatar or user's profile photo if available -->
            <img src="{{ asset('image/logo.png') }}" class="w-8 h-8 rounded-full object-cover">
            <div class="leading-tight">
            <span class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</span><br>
            <span class="text-[11px] text-gray-500 -mt-0.5">{{ Auth::user()->email }}</span>
            </div>
        </div>
      @else
        <a href="{{ route('login') }}" class="text-gray-700 text-decoration-none hover:text-orange-500 font-medium">Masuk</a>
        <a href="{{ route('register') }}" class="bg-orange-500 text-white text-decoration-none px-4 py-2 rounded-lg hover:bg-orange-600 transition">Daftar</a>
      @endauth
    </div>
  </div>
</header>
