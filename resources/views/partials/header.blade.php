<header class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 shadow-sm" x-data="{ mobileOpen: false }">
  <div class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 py-3 text-[14px]">
    <!-- Logo -->
    <a href="{{ route('welcome') }}" class="flex items-center gap-2 sm:gap-3 no-underline group flex-shrink-0">
      <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-orange-50 flex items-center justify-center group-hover:bg-orange-100 transition-colors">
        <img src="{{ asset('image/logo.png') }}" class="w-5 h-5 sm:w-7 sm:h-7">
      </div>
      <div class="leading-tight">
        <span class="font-bold text-gray-900 text-sm sm:text-base tracking-wide">SIANTAR</span><br>
        <span class="text-[10px] sm:text-xs text-gray-500 font-medium">Kesbangpol</span>
      </div>
    </a>

    <!-- Desktop Navigation -->
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

    <!-- Desktop Right Section -->
    <div class="hidden md:flex items-center gap-3">
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

      <!-- Desktop Dropdown Menu -->
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

    <!-- Mobile Hamburger Button -->
    <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg hover:bg-orange-50 text-gray-600 hover:text-orange-500 transition-colors flex-shrink-0">
      <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
      <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>
  </div>

  <!-- Mobile Menu Overlay -->
  <div x-show="mobileOpen" 
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       @click="mobileOpen = false"
       class="md:hidden fixed inset-0 bg-black/50 z-40"
       x-cloak>
  </div>

  <!-- Mobile Slide Menu -->
  <div x-show="mobileOpen"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="translate-x-full"
       class="md:hidden fixed top-0 right-0 h-full w-72 max-w-[85vw] bg-white shadow-2xl z-50 overflow-y-auto"
       x-cloak>
    
    <!-- Mobile Menu Header -->
    <div class="flex items-center justify-between p-4 border-b border-gray-100">
      <span class="font-bold text-gray-900">Menu</span>
      <button @click="mobileOpen = false" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    @auth
    <!-- Mobile User Profile Section -->
    <div class="p-4 bg-gradient-to-r from-orange-50 to-orange-100 border-b border-orange-200">
      <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div class="flex-1 min-w-0">
          <p class="font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
          <p class="text-sm text-gray-600">{{ Auth::user()->roleLabel() }}</p>
        </div>
      </div>
    </div>

    <!-- Mobile Navigation Links -->
    <nav class="p-4 space-y-1">
      <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Navigasi</p>
      
      @php
      $canInputLetter = Auth::user()->hasAnyRole(['sekretariat', 'admin']);
      @endphp
      
      <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors {{ request()->routeIs('dashboard') ? 'bg-orange-50 text-orange-600 font-semibold' : '' }}">
        <i class="bi bi-house text-lg w-6"></i>
        <span>Beranda</span>
      </a>
      
      <a href="{{ route('surat-masuk.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors {{ request()->routeIs('surat-masuk.index') ? 'bg-orange-50 text-orange-600 font-semibold' : '' }}">
        <i class="bi bi-inbox text-lg w-6"></i>
        <span>Surat Masuk</span>
      </a>
      
      <a href="{{ route('surat-keluar.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors {{ request()->routeIs('surat-keluar.index') ? 'bg-orange-50 text-orange-600 font-semibold' : '' }}">
        <i class="bi bi-send text-lg w-6"></i>
        <span>Surat Keluar</span>
      </a>
      
      <a href="{{ route('cari-arsip') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors {{ request()->routeIs('cari-arsip') ? 'bg-orange-50 text-orange-600 font-semibold' : '' }}">
        <i class="bi bi-archive text-lg w-6"></i>
        <span>Arsip</span>
      </a>
      
      @if ($canInputLetter)
      <a href="{{ route('tambah-surat') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors {{ request()->routeIs('tambah-surat') ? 'bg-orange-50 text-orange-600 font-semibold' : '' }}">
        <i class="bi bi-plus-circle text-lg w-6"></i>
        <span>Tambah Surat</span>
      </a>
      @endif
    </nav>

    <!-- Mobile Settings Section -->
    <div class="p-4 border-t border-gray-100">
      <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Pengaturan</p>
      
      @if (Auth::user()->hasRole('admin'))
      <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-orange-50 text-orange-600 font-semibold' : '' }}">
        <i class="bi bi-people text-lg w-6"></i>
        <span>Kelola Pengguna</span>
      </a>
      @endif
      
      <a href="{{ route('pengaturan.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors">
        <i class="bi bi-gear text-lg w-6"></i>
        <span>Pengaturan</span>
      </a>
      
      <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors">
        <i class="bi bi-person text-lg w-6"></i>
        <span>Profil Saya</span>
      </a>
    </div>

    <!-- Mobile Logout Section -->
    <div class="p-4 border-t border-gray-100">
      <form method="POST" action="{{ route('logout') }}" class="m-0">
        @csrf
        <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-colors text-left">
          <i class="bi bi-box-arrow-right text-lg w-6"></i>
          <span>Keluar</span>
        </button>
      </form>
    </div>
    @else
    <!-- Mobile Guest Navigation -->
    <nav class="p-4 space-y-1">
      <a href="{{ route('tentang') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors {{ request()->routeIs('tentang') ? 'bg-orange-50 text-orange-600 font-semibold' : '' }}">
        <i class="bi bi-info-circle text-lg w-6"></i>
        <span>Tentang</span>
      </a>
      
      <a href="{{ route('manfaat') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors {{ request()->routeIs('manfaat') ? 'bg-orange-50 text-orange-600 font-semibold' : '' }}">
        <i class="bi bi-star text-lg w-6"></i>
        <span>Manfaat</span>
      </a>
      
      <a href="{{ route('contact') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 no-underline transition-colors {{ request()->routeIs('contact') ? 'bg-orange-50 text-orange-600 font-semibold' : '' }}">
        <i class="bi bi-envelope text-lg w-6"></i>
        <span>Kontak</span>
      </a>
    </nav>

    <!-- Mobile Login Button -->
    <div class="p-4 border-t border-gray-100">
      <a href="{{ route('login') }}" class="block w-full bg-orange-500 text-white no-underline px-5 py-3 rounded-xl hover:bg-orange-600 transition font-bold text-sm text-center shadow-lg">
        Masuk
      </a>
    </div>
    @endauth
  </div>
</header>