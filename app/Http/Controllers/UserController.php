<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Bumdes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function authorizeSuperAdmin(): void
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses hanya untuk Super Admin.');
        }
    }

    public function index(Request $request)
    {
        $this->authorizeSuperAdmin();

        $query = User::with(['anggota', 'bumdes']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('role')->orderBy('name')->paginate(15)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeSuperAdmin();

        $anggotaList = Anggota::where('status', 'aktif')->orderBy('nama_lengkap')->get();
        $bumdesList  = Bumdes::where('aktif', true)->orderBy('nama')->get();

        return view('users.create', compact('anggotaList', 'bumdesList'));
    }

    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();

        $data = $request->validate([
            'name'                    => 'required|string|max:255',
            'email'                   => 'required|email|unique:users,email',
            'password'                => 'required|string|min:8|confirmed',
            'role'                    => 'required|in:superadmin,admin,operator,admin_desa,petani,bumdes',
            'aktif'                   => 'boolean',
            'wilayah_kabupaten_id'    => 'nullable|string',
            'wilayah_kabupaten_nama'  => 'nullable|string',
            'wilayah_kecamatan_id'    => 'nullable|string',
            'wilayah_kecamatan_nama'  => 'nullable|string',
            'wilayah_desa_id'         => 'nullable|string',
            'wilayah_desa_nama'       => 'nullable|string',
            'anggota_id'              => 'nullable|exists:anggota,id',
            'bumdes_id'               => 'nullable|exists:bumdes,id',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['aktif']    = $request->boolean('aktif', true);

        // Clear unrelated fields per role
        $data = $this->cleanRoleFields($data);

        User::create($data);

        return redirect()->route('users.index')
            ->with('success', 'User "' . $data['name'] . '" berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $this->authorizeSuperAdmin();

        $anggotaList = Anggota::where('status', 'aktif')->orderBy('nama_lengkap')->get();
        $bumdesList  = Bumdes::where('aktif', true)->orderBy('nama')->get();

        return view('users.edit', compact('user', 'anggotaList', 'bumdesList'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeSuperAdmin();

        $data = $request->validate([
            'name'                    => 'required|string|max:255',
            'email'                   => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password'                => 'nullable|string|min:8|confirmed',
            'role'                    => 'required|in:superadmin,admin,operator,admin_desa,petani,bumdes',
            'aktif'                   => 'boolean',
            'wilayah_kabupaten_id'    => 'nullable|string',
            'wilayah_kabupaten_nama'  => 'nullable|string',
            'wilayah_kecamatan_id'    => 'nullable|string',
            'wilayah_kecamatan_nama'  => 'nullable|string',
            'wilayah_desa_id'         => 'nullable|string',
            'wilayah_desa_nama'       => 'nullable|string',
            'anggota_id'              => 'nullable|exists:anggota,id',
            'bumdes_id'               => 'nullable|exists:bumdes,id',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['aktif'] = $request->boolean('aktif', true);
        $data = $this->cleanRoleFields($data);

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User "' . $user->name . '" berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->authorizeSuperAdmin();

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', 'User "' . $name . '" berhasil dihapus.');
    }

    /** Remove wilayah / anggota / bumdes fields that don't apply to the selected role */
    private function cleanRoleFields(array $data): array
    {
        $role = $data['role'] ?? '';

        if (!in_array($role, ['admin_desa'])) {
            $data['wilayah_kabupaten_id']   = null;
            $data['wilayah_kabupaten_nama']  = null;
            $data['wilayah_kecamatan_id']    = null;
            $data['wilayah_kecamatan_nama']  = null;
            $data['wilayah_desa_id']         = null;
            $data['wilayah_desa_nama']       = null;
        }

        if ($role !== 'petani') {
            $data['anggota_id'] = null;
        }

        if ($role !== 'bumdes') {
            $data['bumdes_id'] = null;
        }

        return $data;
    }
}
