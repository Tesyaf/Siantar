<x-app-layout>
    <main class="container py-4">
        <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none fw-semibold d-inline-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>

        <div class="mt-4">
            <h1 class="text-2xl font-extrabold text-gray-900 mb-2">
                <i class="bi bi-google text-danger me-2"></i>Google Drive Connected!
            </h1>
            <p class="text-gray-500">Berhasil mendapatkan akses ke Google Drive.</p>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Authorization berhasil untuk akun: <strong>{{ $email ?? 'Unknown' }}</strong>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Refresh Token</label>
                    <div class="input-group">
                        <input type="text" class="form-control font-monospace" id="refreshToken" value="{{ $refreshToken }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyToken()">
                            <i class="bi bi-clipboard"></i> Copy
                        </button>
                    </div>
                    <div class="form-text">Simpan token ini di file <code>.env</code></div>
                </div>

                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Langkah selanjutnya:</strong>
                    <ol class="mb-0 mt-2">
                        <li>Copy Refresh Token di atas</li>
                        <li>Buka file <code>.env</code></li>
                        <li>Paste di baris: <code>GOOGLE_REFRESH_TOKEN=paste_token_disini</code></li>
                        <li>Jalankan: <code>php artisan config:clear</code></li>
                        <li>Test dengan upload surat baru</li>
                    </ol>
                </div>

                <div class="mt-4">
                    <a href="{{ route('dashboard') }}" class="btn text-white fw-bold" style="background-color: #ff7f00;">
                        <i class="bi bi-house me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </main>

    <script>
        function copyToken() {
            const input = document.getElementById('refreshToken');
            input.select();
            document.execCommand('copy');
            alert('Refresh Token berhasil dicopy!');
        }
    </script>
</x-app-layout>