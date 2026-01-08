<!-- Kepala Badan Profile Section -->
<section class="space-y-6">
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-8 text-white">
        <div class="flex items-center gap-4">
            <div class="w-24 h-24 rounded-full bg-purple-300 flex items-center justify-center text-4xl font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-3xl font-bold">{{ $user->name }}</h2>
                <p class="text-purple-100 mt-1">Kepala Badan</p>
                <p class="text-xs text-purple-100 mt-2">NIP: {{ $user->nip ?? 'Belum diisi' }}</p>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <h3 class="font-bold text-lg mb-4">Informasi Pribadi</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                    <p class="text-gray-900 font-semibold mt-1">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Email</label>
                    <p class="text-gray-900 font-semibold mt-1">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Username</label>
                    <p class="text-gray-900 font-semibold mt-1">{{ $user->username }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">NIP</label>
                    <p class="text-gray-900 font-semibold mt-1">{{ $user->nip ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <h3 class="font-bold text-lg mb-4">Informasi Posisi</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-600">Jabatan</label>
                    <p class="text-gray-900 font-semibold mt-1">Kepala Badan Kesatuan Bangsa dan Politik</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Departemen</label>
                    <p class="text-gray-900 font-semibold mt-1">Kesbangpol</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Status Akun</label>
                    <div class="mt-1">
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">Aktif</span>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Bergabung Sejak</label>
                    <p class="text-gray-900 font-semibold mt-1">{{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4">
            <p class="text-xs font-medium text-blue-600">Total Surat Masuk</p>
            <p class="text-2xl font-bold text-blue-900 mt-2">{{ $incomingTotal ?? 0 }}</p>
        </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4">
            <p class="text-xs font-medium text-green-600">Total Surat Keluar</p>
            <p class="text-2xl font-bold text-green-900 mt-2">{{ $outgoingTotal ?? 0 }}</p>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4">
            <p class="text-xs font-medium text-purple-600">Menunggu Persetujuan</p>
            <p class="text-2xl font-bold text-purple-900 mt-2">{{ $pendingApproval ?? 0 }}</p>
        </div>
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4">
            <p class="text-xs font-medium text-orange-600">Surat Diproses</p>
            <p class="text-2xl font-bold text-orange-900 mt-2">{{ $inProgress ?? 0 }}</p>
        </div>
    </div>
</section>