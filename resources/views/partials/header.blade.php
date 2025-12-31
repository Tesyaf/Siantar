<header class="bg-white border-b sticky top-0 z-50">
  <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-3 text-[12px]">
    <div class="flex items-center gap-2">
      <img src="{{ asset('image/logo.png') }}" class="w-9 h-9">
      <div class="leading-tight">
        <span class="font-semibold text-gray-800 text-sm">SIANTAR</span><br>
        <span class="text-[11px] text-gray-500 -mt-1">Kesbangpol</span>
      </div>
    </div>
    <nav class="flex gap-6 text-gray-700">
      <a href="{{ route('welcome') }}" class="hover:text-orange-500 {{ request()->routeIs('welcome') ? 'font-bold text-orange-500' : '' }}">Beranda</a>
      <a href="{{ route('tentang') }}" class="hover:text-orange-500 {{ request()->routeIs('tentang') ? 'font-bold text-orange-500' : '' }}">Tentang</a>
      <a href="{{ route('manfaat') }}" class="hover:text-orange-500 {{ request()->routeIs('manfaat') ? 'font-bold text-orange-500' : '' }}">Manfaat</a>
      <a href="{{ route('contact') }}" class="hover:text-orange-500 {{ request()->routeIs('contact') ? 'font-bold text-orange-500' : 'font-semibold' }}">Kontak</a>
    </nav>
    <div class="flex items-center gap-4">
      @auth
        <div class="relative">
            <i class="fa-solid fa-bell text-gray-700"></i>
            <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-[10px] rounded-full px-1.5">3</span>
        </div>
        <a href="{{ route('dashboard') }}">
            <i class="fa-solid fa-gear text-gray-700"></i>
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
        <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500 font-medium">Masuk</a>
        <a href="{{ route('register') }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition">Daftar</a>
      @endauth
    </div>
  </div>
</header>
