<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIANTAR - Sistem Arsip Naskah dan Tata Persuratan</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- AOS Animation CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white text-gray-900 scroll-smooth">

    <!-- Header / Navbar -->
    @include('partials.header')

    <!-- Hero Section -->
    <section id="beranda" class="relative min-h-screen flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('image/bg.png') }}" class="w-full h-full object-cover" alt="Background">
            <div class="absolute inset-0 bg-black/60"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <div data-aos="fade-down" data-aos-duration="800" class="inline-flex items-center gap-2.5 pl-2 pr-5 py-1.5 rounded-full bg-black/30 backdrop-blur-md border border-white/20 mb-8">
                <div class="flex items-center justify-center w-6 h-6 rounded-full border border-white/40 bg-white/10">
                    <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                </div>
                <span class="text-[11px] font-bold text-white/90 tracking-[0.1em] uppercase">Badan Kesatuan Bangsa dan Politik</span>
            </div>

            <h1 data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000" class="text-6xl md:text-8xl font-extrabold mb-4 tracking-tight">SIANTAR</h1>
            <h2 data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000" class="text-2xl md:text-4xl font-bold mb-8 text-white">Sistem Arsip Naskah dan Tata Persuratan</h2>
            <p data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" class="max-w-3xl mx-auto text-[18px] text-[#E5E7EB] mb-12 leading-[30px] font-normal text-center">
                Platform digital terintegrasi untuk pengelolaan surat masuk, surat keluar, dan pengarsipan naskah secara efisien dan terstruktur. Meningkatkan tertib administrasi dan mempercepat proses persuratan di lingkungan Kesbangpol.
            </p>

            <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" class="flex flex-col sm:flex-row justify-center gap-5">
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-xl bg-brand-orange text-white font-bold text-sm hover:opacity-90 transition shadow-xl shadow-brand-orange/20 flex items-center justify-center gap-2 transform hover:scale-105 duration-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Masuk ke Sistem
                </a>
                <a href="{{ route('register') }}" class="px-8 py-4 rounded-xl bg-white text-brand-orange font-bold text-sm hover:bg-gray-50 transition shadow-xl flex items-center justify-center gap-2 transform hover:scale-105 duration-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    Daftar Akun
                </a>
            </div>

            <div class="flex flex-wrap justify-center gap-12 mt-20">
                <div data-aos="fade-right" data-aos-delay="600" class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-white/10 border border-white/10"><svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg></div>
                    <div class="text-left text-xs font-bold uppercase tracking-widest">Aman <span class="block text-[9px] text-gray-400 font-medium normal-case mt-0.5">Terenkripsi</span></div>
                </div>
                <div data-aos="fade-up" data-aos-delay="700" class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-white/10 border border-white/10"><svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg></div>
                    <div class="text-left text-xs font-bold uppercase tracking-widest">Cepat <span class="block text-[9px] text-gray-400 font-medium normal-case mt-0.5">Real-time</span></div>
                </div>
                <div data-aos="fade-left" data-aos-delay="800" class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-white/10 border border-white/10"><svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg></div>
                    <div class="text-left text-xs font-bold uppercase tracking-widest">Efisien <span class="block text-[9px] text-gray-400 font-medium normal-case mt-0.5">Terintegrasi</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Section -->
    <section id="tentang" class="py-28 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20" data-aos="fade-up">
                <h2 class="text-4xl font-extrabold mb-4 text-gray-900">Tentang Sistem SIANTAR</h2>
                <div class="w-20 h-1.5 bg-brand-orange mx-auto mb-8 rounded-full"></div>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">Solusi digital untuk modernisasi tata kelola persuratan dan pengarsipan naskah di lingkungan Badan Kesatuan Bangsa dan Politik.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div data-aos="fade-up" data-aos-delay="100" class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl transition duration-300 group hover:-translate-y-2">
                    <div class="w-16 h-16 bg-brand-orange rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-brand-orange/30 group-hover:scale-110 transition-transform">
                        <!-- Icon: Inbox In -->
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h4.753a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" /></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Surat Masuk</h3>
                    <p class="text-gray-500 leading-relaxed">Pendaftaran dan pelacakan surat masuk secara digital dengan sistem disposisi otomatis dan notifikasi real-time.</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="200" class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl transition duration-300 group hover:-translate-y-2">
                    <div class="w-16 h-16 bg-brand-orange rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-brand-orange/30 group-hover:scale-110 transition-transform">
                        <!-- Icon: Paper Airplane -->
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Surat Keluar</h3>
                    <p class="text-gray-500 leading-relaxed">Pembuatan dan pengiriman surat keluar dengan sistem approval bertingkat dan tracking status pengiriman.</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="300" class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl transition duration-300 group hover:-translate-y-2">
                    <div class="w-16 h-16 bg-brand-orange rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-brand-orange/30 group-hover:scale-110 transition-transform">
                        <!-- Icon: Folder Open -->
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Arsip Digital</h3>
                    <p class="text-gray-500 leading-relaxed">Penyimpanan dan pengelolaan arsip naskah secara terstruktur dengan sistem pencarian cepat dan aman.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Manfaat Section -->
    <section id="manfaat" class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-24 items-center">
                <div class="lg:w-1/2" data-aos="fade-right">
                    <span class="text-brand-orange font-bold uppercase tracking-widest text-xs mb-4 block">Keunggulan Sistem</span>
                    <h2 class="text-5xl font-extrabold mb-10 leading-tight text-gray-900">Manfaat SIANTAR untuk Instansi</h2>
                    
                    <div class="space-y-8">
                        @foreach(['Kemudahan Pengarsipan Digital', 'Efisiensi Pengelolaan Surat', 'Peningkatan Tertib Administrasi', 'Keamanan Data Terjamin'] as $idx => $m)
                        <div class="flex items-start gap-5" data-aos="fade-up" data-aos-delay="{{ $idx * 100 }}">
                            <div class="w-8 h-8 rounded-lg bg-brand-orange flex items-center justify-center shrink-0 mt-1 shadow-md shadow-brand-orange/20">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">{{ $m }}</h4>
                                <p class="text-gray-500 mt-1 leading-relaxed text-sm">Sistem yang dirancang khusus untuk memenuhi standar operasional prosedur pemerintahan yang modern.</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="lg:w-1/2" data-aos="fade-left">
                    <div class="bg-gray-50 rounded-[3.5rem] p-10 border border-gray-100 shadow-2xl shadow-gray-200/50 relative">
                        <!-- Decoration -->
                        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-brand-orange/5 rounded-full blur-3xl animate-pulse"></div>
                        
                        <div class="grid grid-cols-2 gap-8 relative z-10">
                            <div class="bg-white p-8 rounded-3xl flex flex-col items-center text-center shadow-sm hover:scale-105 transition duration-300">
                                <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center mb-4 text-brand-orange"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg></div>
                                <div class="text-4xl font-black text-gray-900 mb-1">100%</div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Paperless</div>
                            </div>
                            <div class="bg-white p-8 rounded-3xl flex flex-col items-center text-center shadow-sm hover:scale-105 transition duration-300">
                                <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center mb-4 text-brand-orange"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                                <div class="text-4xl font-black text-gray-900 mb-1">70%</div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Lebih Cepat</div>
                            </div>
                            <div class="bg-white p-8 rounded-3xl flex flex-col items-center text-center shadow-sm hover:scale-105 transition duration-300">
                                <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center mb-4 text-brand-orange"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg></div>
                                <div class="text-xl font-black text-gray-900">Aman</div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Terenkripsi</div>
                            </div>
                            <div class="bg-white p-8 rounded-3xl flex flex-col items-center text-center shadow-sm hover:scale-105 transition duration-300">
                                <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center mb-4 text-brand-orange"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg></div>
                                <div class="text-xl font-black text-gray-900">Multi</div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">User Access</div>
                            </div>
                        </div>
                        <button class="w-full mt-10 py-4 rounded-2xl bg-brand-orange text-white font-bold hover:opacity-90 transition shadow-lg shadow-brand-orange/20 hover:scale-105 transform duration-300">Sistem Terintegrasi untuk Administrasi Modern</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Unggulan -->
    <section id="fitur" class="py-32 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20" data-aos="fade-up">
                <h2 class="text-4xl font-extrabold mb-4 text-gray-900">Fitur Unggulan</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">Dilengkapi dengan berbagai fitur canggih untuk mendukung pengelolaan arsip dan tata persuratan yang profesional.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div data-aos="flip-left" data-aos-delay="100" class="bg-white p-12 rounded-[3rem] shadow-sm border border-gray-100 text-center flex flex-col items-center hover:shadow-lg transition duration-300 group hover:-translate-y-2">
                    <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center mb-8 text-brand-orange group-hover:bg-brand-orange group-hover:text-white transition-colors duration-300"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg></div>
                    <h3 class="text-xl font-bold mb-4 text-gray-900">Manajemen Arsip</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Pengelolaan dan pengelompokan arsip surat masuk dan surat keluar secara digital agar dokumen tersimpan rapi, aman, dan mudah dikelola.</p>
                </div>
                <div data-aos="flip-left" data-aos-delay="200" class="bg-white p-12 rounded-[3rem] shadow-sm border border-gray-100 text-center flex flex-col items-center hover:shadow-lg transition duration-300 group hover:-translate-y-2">
                    <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center mb-8 text-brand-orange group-hover:bg-brand-orange group-hover:text-white transition-colors duration-300"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg></div>
                    <h3 class="text-xl font-bold mb-4 text-gray-900">Pencarian Cerdas</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Fitur pencarian arsip berdasarkan nomor surat, perihal, tanggal, atau instansi sehingga surat dapat ditemukan dengan cepat tanpa membuka buku agenda manual.</p>
                </div>
                <div data-aos="flip-left" data-aos-delay="300" class="bg-white p-12 rounded-[3rem] shadow-sm border border-gray-100 text-center flex flex-col items-center hover:shadow-lg transition duration-300 group hover:-translate-y-2">
                    <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center mb-8 text-brand-orange group-hover:bg-brand-orange group-hover:text-white transition-colors duration-300"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg></div>
                    <h3 class="text-xl font-bold mb-4 text-gray-900">Laporan Analitik</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Penyajian rekapitulasi data surat masuk dan surat keluar dalam bentuk laporan untuk membantu evaluasi dan kebutuhan administrasi instansi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-brand-orange relative overflow-hidden" data-aos="fade-up">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full -ml-32 -mb-32"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 text-white">
            <h2 class="text-4xl font-bold mb-6">Mulai Gunakan SIANTAR Sekarang</h2>
            <p class="text-xl text-orange-100 mb-10 max-w-2xl mx-auto">Tingkatkan efisiensi pengelolaan persuratan dan pengarsipan di instansi Anda.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-xl bg-white text-brand-orange font-bold hover:bg-gray-100 transition shadow-xl flex items-center justify-center gap-2 hover:scale-105 transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Masuk ke Sistem
                </a>
                <a href="{{ route('tentang') }}" class="px-8 py-4 rounded-xl border-2 border-white text-white font-bold hover:bg-white/10 transition flex items-center justify-center gap-2 hover:scale-105 transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('partials.footer')

    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true, // Animation happens only once - while scrolling down
            offset: 50, // offset (in px) from the original trigger point
            duration: 800, // values from 0 to 3000, with step 50ms
            easing: 'ease-out-cubic', // default easing for AOS animations
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                // Check if target is on the current page
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>