<x-app-layout>
  <main class="container py-4">
    <a href="{{ route('admin.users.index') }}" class="text-muted text-decoration-none fw-semibold d-inline-flex align-items-center gap-2 hover:text-gray-800">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <div class="mt-2">
      <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Tambah Pengguna</h1>
      <p class="text-gray-500 mb-0">Buat akun baru untuk akses ke sistem.</p>
    </div>

    <form class="card border-0 shadow-sm mt-4" method="POST" action="{{ route('admin.users.store') }}">
      @csrf
      <div class="card-body">
        <div class="row g-3">
          <div class="col-lg-6">
            <label class="form-label fw-bold text-gray-700">Nama Lengkap</label>
            <input class="form-control" type="text" name="name" value="{{ old('name') }}" required />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
          </div>
          <div class="col-lg-6">
            <label class="form-label fw-bold text-gray-700">Username</label>
            <input class="form-control" type="text" name="username" value="{{ old('username') }}" required />
            <x-input-error :messages="$errors->get('username')" class="mt-1" />
          </div>
          <div class="col-lg-6">
            <label class="form-label fw-bold text-gray-700">Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
          </div>
          <div class="col-lg-6">
            <label class="form-label fw-bold text-gray-700">NIP</label>
            <input class="form-control" type="text" name="nip" value="{{ old('nip') }}" />
            <x-input-error :messages="$errors->get('nip')" class="mt-1" />
          </div>
          <div class="col-lg-6">
            <label class="form-label fw-bold text-gray-700">Role</label>
            <select class="form-select" name="role" required>
              @foreach ($roleOptions as $roleValue => $roleLabel)
              <option value="{{ $roleValue }}" @selected(old('role', 'sekretariat' )===$roleValue)>{{ $roleLabel }}</option>
              @endforeach
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-1" />
          </div>
          <div class="col-lg-6">
            <label class="form-label fw-bold text-gray-700">Kata Sandi</label>
            <input class="form-control" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
          </div>
          <div class="col-lg-6">
            <label class="form-label fw-bold text-gray-700">Konfirmasi Kata Sandi</label>
            <input class="form-control" type="password" name="password_confirmation" required />
          </div>
        </div>
      </div>

      <div class="card-footer bg-white border-0 d-flex justify-content-end gap-2">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary fw-bold">Batal</a>
        <button class="btn text-white border-0 fw-bold" style="background-color: #ff7f00;" type="submit">
          Simpan Pengguna
        </button>
      </div>
    </form>
  </main>
</x-app-layout>