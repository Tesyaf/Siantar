<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - SIANTAR</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 antialiased min-h-screen flex items-center justify-center p-4 relative">

    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('image/bg.png') }}" class="w-full h-full object-cover" alt="Background">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>
    </div>

    <!-- Back Button -->
    <a href="/" class="absolute top-8 left-8 flex items-center gap-2 text-white hover:text-orange-200 transition font-medium text-sm z-20">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        Kembali
    </a>

    <div class="max-w-5xl w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col lg:flex-row h-auto relative z-10 my-12">
        
        <!-- Left Side (Info) -->
        <div class="lg:w-[45%] p-12 text-white flex flex-col justify-center relative overflow-hidden min-h-[600px]" style="background: linear-gradient(45deg, #FF7F00 0%, #E1E1E1 250%); border: 0 solid #E5E7EB;">
            <!-- Decorative Circles -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-orange-700/20">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo" class="h-12 w-auto">
                </div>
                
                <h2 class="text-4xl font-extrabold mb-4 leading-tight text-white">Selamat Datang di SIANTAR</h2>
                <p class="text-orange-50 text-lg mb-2 font-medium">Sistem Arsip Naskah dan Tata Persuratan</p>
                <p class="text-orange-100 text-sm mb-12">Badan Kesatuan Bangsa dan Politik</p>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-white text-sm">Keamanan Terjamin</h4>
                            <p class="text-orange-50 text-xs mt-0.5">Data arsip terenkripsi dan terlindungi</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-white text-sm">Manajemen Dokumen</h4>
                            <p class="text-orange-50 text-xs mt-0.5">Kelola surat dengan mudah dan efisien</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-white text-sm">Akses 24/7</h4>
                            <p class="text-orange-50 text-xs mt-0.5">Tersedia kapan saja dan dimana saja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side (Form) -->
        <div class="lg:w-[55%] p-12 lg:p-16">
            <div class="text-center mb-10">
                <h3 class="text-3xl font-extrabold text-gray-900 mb-2">Daftar Akun</h3>
                <p class="text-gray-500">Silakan lengkapi data diri untuk mendaftar</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Nama Lengkap
                    </label>
                    <input id="name" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20 transition text-sm placeholder-gray-400" type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- NIP / ID Pegawai -->
                <div>
                    <label for="nip" class="block text-sm font-bold text-gray-700 mb-1.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .854.542 1.555 1.332 1.86" /></svg>
                        NIP / ID Pegawai
                    </label>
                    <input id="nip" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20 transition text-sm placeholder-gray-400" type="text" name="nip" value="{{ old('nip') }}" placeholder="Masukkan NIP atau ID Pegawai" />
                    <x-input-error :messages="$errors->get('nip')" class="mt-1" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        Email
                    </label>
                    <input id="email" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20 transition text-sm placeholder-gray-400" type="email" name="email" value="{{ old('email') }}" placeholder="nama@kesbangpol.go.id" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-bold text-gray-700 mb-1.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                        Username
                    </label>
                    <input id="username" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20 transition text-sm placeholder-gray-400" type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required />
                    <x-input-error :messages="$errors->get('username')" class="mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <input id="password" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20 transition text-sm placeholder-gray-400 pr-10" type="password" name="password" placeholder="Masukkan kata sandi" required autocomplete="new-password" />
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-brand-orange focus:outline-none">
                            <svg id="eye-icon-password" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-off-icon-password" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20 transition text-sm placeholder-gray-400 pr-10" type="password" name="password_confirmation" placeholder="Konfirmasi kata sandi" required />
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-brand-orange focus:outline-none">
                            <svg id="eye-icon-password_confirmation" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-off-icon-password_confirmation" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <script>
                    function togglePassword(fieldId) {
                        const input = document.getElementById(fieldId);
                        const eyeIcon = document.getElementById('eye-icon-' + fieldId);
                        const eyeOffIcon = document.getElementById('eye-off-icon-' + fieldId);
                        
                        if (input.type === 'password') {
                            input.type = 'text';
                            eyeIcon.classList.add('hidden');
                            eyeOffIcon.classList.remove('hidden');
                        } else {
                            input.type = 'password';
                            eyeIcon.classList.remove('hidden');
                            eyeOffIcon.classList.add('hidden');
                        }
                    }
                </script>

                <!-- Terms -->
                <div class="flex items-center pt-2">
                    <input id="terms" type="checkbox" class="w-4 h-4 text-brand-orange border-gray-300 rounded focus:ring-brand-orange cursor-pointer" required>
                    <label for="terms" class="ml-2 text-sm text-gray-500">
                        Saya menyetujui <a href="#" class="text-brand-orange font-bold hover:underline">syarat dan ketentuan</a> penggunaan SIANTAR Kesbangpol
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3.5 px-4 bg-brand-orange hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-200 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mt-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    Daftar Sekarang
                </button>

                <!-- Login Link -->
                <div class="text-center mt-6 text-sm text-gray-500">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="text-brand-orange font-bold hover:underline">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>