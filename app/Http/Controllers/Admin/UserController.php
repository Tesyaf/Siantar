<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private const ROLE_OPTIONS = [
        'admin' => 'Admin',
        'sekretariat' => 'Sekretariat',
    ];

    public function index(Request $request)
    {
        $this->authorizeAdmin($request);

        $query = User::query()->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('nip', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'roleOptions' => self::ROLE_OPTIONS,
        ]);
    }

    public function create(Request $request)
    {
        $this->authorizeAdmin($request);

        return view('admin.users.create', [
            'roleOptions' => self::ROLE_OPTIONS,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin($request);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class, 'username')],
            'nip' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'role' => ['required', Rule::in(array_keys(self::ROLE_OPTIONS))],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(Request $request, User $user)
    {
        $this->authorizeAdmin($request);

        return view('admin.users.edit', [
            'user' => $user,
            'roleOptions' => self::ROLE_OPTIONS,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeAdmin($request);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class, 'username')->ignore($user->id)],
            'nip' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class, 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(array_keys(self::ROLE_OPTIONS))],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        if ($request->user()->is($user) && $data['role'] !== 'admin') {
            return back()->with('error', 'Role akun sendiri tidak bisa diubah selain Admin.');
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user)
    {
        $this->authorizeAdmin($request);

        if ($request->user()->is($user)) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    private function authorizeAdmin(Request $request): void
    {
        if (!$request->user() || !$request->user()->hasRole('admin')) {
            abort(403);
        }
    }
}
