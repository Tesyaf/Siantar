<x-guest-layout>
    <div class="w-full h-screen relative overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('image/bg.png') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/20"></div>
        </div>

        <div class="absolute top-6 left-6 z-20">
            <a href="{{ url('/') }}" class="flex items-center text-black font-medium gap-2 hover:text-gray-700 transition">
                <i class="fas fa-arrow-left text-black"></i> Kembali
            </a>
        </div>

        <div class="relative z-10 w-full h-full flex items-center justify-center px-4">
            <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-8 text-center">

                <img src="{{ asset('image/logo.png') }}" class="mx-auto h-20 mb-4"/>

                <h2 class="text-2xl font-extrabold text-gray-900 mb-2 tracking-wide">
                    Selamat Datang Kembali di
                    <br>
                    <span class="text-3xl font-black">SIANTAR</span>
                </h2>

                <!-- garis tipis & panjang -->
                <div class="w-full border-b border-gray-300/70 mb-3"></div>

                <!-- teks deskripsi disamakan stylingnya -->
                <p class="text-sm leading-relaxed text-gray-600 mb-1">
                    Sistem Arsip Naskah dan Tata Persuratan
                </p>
                <p class="text-sm font-semibold text-gray-700 tracking-wide">
                    Badan Kesatuan Bangsa dan Politik
                </p>

                <form method="POST" action="{{ route('login') }}" class="space-y-4 text-left mt-6">
                    @csrf
                    <div>
                        <label for="email" class="text-sm font-medium text-gray-700 flex gap-2 mb-1">
                            <i class="fas fa-user text-orange"></i> Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }} focus:ring-2 focus:ring-orange-300 outline-none">
                        @if ($errors->has('email'))
                            <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="password" class="text-sm font-medium text-gray-700 flex gap-2 mb-1">
                            <i class="fas fa-lock text-orange"></i> Kata Sandi
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required placeholder="Masukkan kata sandi"
                                class="w-full px-4 py-3 rounded-xl bg-gray-50 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-200' }} focus:ring-2 focus:ring-orange-300 outline-none pr-10">
                            <i class="fas fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer" onclick="togglePassword()"></i>
                        </div>
                        @if ($errors->has('password'))
                            <p class="text-red-500 text-xs mt-1">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-orange font-semibold hover:text-orange-600">Lupa Kata Sandi?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-orange text-white font-bold py-3 rounded-xl shadow-lg flex justify-center gap-2 hover:bg-orange-600 transition duration-200">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>
                </form>

                <p class="text-sm text-gray-600 mt-6">
                    Belum memiliki akun? <a href="{{ route('register') }}" class="font-bold text-orange hover:text-orange-600">Daftar</a>
                </p>

                <div class="mt-4 flex justify-center">
                    <div class="flex items-center gap-2 bg-gray-100 px-4 py-2 rounded-full text-xs font-semibold text-gray-600 shadow">
                        <i class="fas fa-shield-alt text-orange"></i>
                        Koneksi Aman & Terenkripsi
                    </div>
                </div>

            </div>
        </div>

        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const icon = event.currentTarget;
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        </script>
    </div>
</x-guest-layout>