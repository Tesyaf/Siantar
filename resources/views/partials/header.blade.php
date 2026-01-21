<header class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 shadow-sm">
  <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-3 text-[14px]">
    <a href="{{ route('welcome') }}" class="flex items-center gap-3 no-underline group">
      <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center group-hover:bg-orange-100 transition-colors">
        <img src="{{ asset('image/logo.png') }}" class="w-7 h-7">
      </div>
      <div class="leading-tight">
        <span class="font-bold text-gray-900 text-base tracking-wide">SIANTAR</span><br>
        <span class="text-xs text-gray-500 font-medium">Kesbangpol</span>
      </div>
    </a>

    <nav class="hidden md:flex gap-6 text-gray-600">
      @auth
      @php
      $canInputLetter = Auth::user()->hasAnyRole(['sekretariat', 'admin']);
      @endphp
      <a href="{{ route('dashboard') }}" class="no-underline text-[16px] font-normal text-gray-600 hover:text-orange-500 transition-colors {{ request()->routeIs('dashboard') ? '!text-orange-500 !font-semibold' : '' }}">Beranda</a>
      <a href="{{ route('surat-masuk.index') }}" class="no-underline text-[16px] font-normal text-gray-600 hover:text-orange-500 transition-colors {{ request()->routeIs('surat-masuk.index') ? '!text-orange-500 !font-semibold' : '' }}">Surat Masuk</a>
      <a href="{{ route('surat-keluar.index') }}" class="no-underline text-[16px] font-normal text-gray-600 hover:text-orange-500 transition-colors {{ request()->routeIs('surat-keluar.index') ? '!text-orange-500 !font-semibold' : '' }}">Surat Keluar</a>
      <a href="{{ route('cari-arsip') }}" class="no-underline text-[16px] font-normal text-gray-600 hover:text-orange-500 transition-colors {{ request()->routeIs('cari-arsip') ? '!text-orange-500 !font-semibold' : '' }}">Arsip</a>
      @if ($canInputLetter)
      <a href="{{ route('tambah-surat') }}" class="no-underline text-[16px] font-normal text-gray-600 hover:text-orange-500 transition-colors {{ request()->routeIs('tambah-surat') ? '!text-orange-500 !font-semibold' : '' }}">Tambah Surat</a>
      @endif
      @else
      <a href="{{ route('tentang') }}" class="no-underline text-[16px] font-normal text-gray-600 hover:text-orange-500 transition-colors {{ request()->routeIs('tentang') ? '!text-orange-500 !font-semibold' : '' }}">Tentang</a>
      <a href="{{ route('manfaat') }}" class="no-underline text-[16px] font-normal text-gray-600 hover:text-orange-500 transition-colors {{ request()->routeIs('manfaat') ? '!text-orange-500 !font-semibold' : '' }}">Manfaat</a>
      <a href="{{ route('contact') }}" class="no-underline text-[16px] font-normal text-gray-600 hover:text-orange-500 transition-colors {{ request()->routeIs('contact') ? '!text-orange-500 !font-semibold' : '' }}">Kontak</a>
      @endauth
    </nav>

    <div class="flex items-center gap-3">
      @auth
      <!-- User Avatar -->
      <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 no-underline group">
        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div class="leading-tight hidden lg:block">
          <span class="text-base font-semibold text-gray-800 group-hover:text-orange-500 transition-colors">{{ Auth::user()->name }}</span><br>
          <span class="text-xs text-gray-500">{{ Auth::user()->roleLabel() }}</span>
        </div>
      </a>

      <!-- Dropdown Menu (di paling kanan) -->
      <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="p-2 rounded-lg hover:bg-orange-50 text-gray-600 hover:text-orange-500 transition-colors">
          <i class="bi bi-three-dots-vertical text-lg"></i>
        </button>
        <div x-show="open" @click.outside="open = false"
          x-transition:enter="transition ease-out duration-100"
          x-transition:enter-start="opacity-0 scale-95"
          x-transition:enter-end="opacity-100 scale-100"
          x-transition:leave="transition ease-in duration-75"
          x-transition:leave-start="opacity-100 scale-100"
          x-transition:leave-end="opacity-0 scale-95"
          class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">

          @if (Auth::user()->hasRole('admin'))
          <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors {{ request()->routeIs('admin.users.*') ? '!bg-orange-50 !text-orange-600' : '' }}">
            <i class="bi bi-people text-base"></i> Kelola Pengguna
          </a>
          @endif

          <a href="{{ route('notifikasi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors">
            <i class="bi bi-bell text-base"></i> Notifikasi
          </a>

          <a href="{{ route('pengaturan.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors">
            <i class="bi bi-gear text-base"></i> Pengaturan
          </a>

          <div class="border-t border-gray-100 my-2"></div>

          <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors">
            <i class="bi bi-person text-base"></i> Profil Saya
          </a>

          <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
              <i class="bi bi-box-arrow-right text-base"></i> Keluar
            </button>
          </form>
        </div>
      </div>
      @else
      <a href="{{ route('login') }}" class="bg-orange-500 text-white no-underline px-5 py-2.5 rounded-xl hover:bg-orange-600 transition font-bold text-sm shadow-orange">Masuk</a>
      @endauth
    </div>
  </div>

  <!-- Mobile Menu Button -->
  <div class="md:hidden px-6 pb-3" x-data="{ mobileOpen: false }">
    <button @click="mobileOpen = !mobileOpen" class="text-gray-600 hover:text-orange-500">
      <i class="bi bi-list text-2xl"></i>
    </button>
    <div x-show="mobileOpen" class="mt-3 space-y-2">
      @auth
      <a href="{{ route('dashboard') }}" class="block py-2 text-gray-600 hover:text-orange-500 no-underline">Beranda</a>
      <a href="{{ route('surat-masuk.index') }}" class="block py-2 text-gray-600 hover:text-orange-500 no-underline">Surat Masuk</a>
      <a href="{{ route('surat-keluar.index') }}" class="block py-2 text-gray-600 hover:text-orange-500 no-underline">Surat Keluar</a>
      <a href="{{ route('cari-arsip') }}" class="block py-2 text-gray-600 hover:text-orange-500 no-underline">Arsip</a>
      @else
      <a href="{{ route('tentang') }}" class="block py-2 text-gray-600 hover:text-orange-500 no-underline">Tentang</a>
      <a href="{{ route('manfaat') }}" class="block py-2 text-gray-600 hover:text-orange-500 no-underline">Manfaat</a>
      <a href="{{ route('contact') }}" class="block py-2 text-gray-600 hover:text-orange-500 no-underline">Kontak</a>
      @endauth
    </div>
  </div>
</header>