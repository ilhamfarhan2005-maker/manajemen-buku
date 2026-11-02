<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    /**
     * Seluruh route di controller ini dilindungi middleware 'permission:manage roles'
     * (hanya Admin) di routes/web.php.
     */
    public function index(): View
    {
        $users = User::with('roles')->orderBy('name')->paginate(15);
        $roles = Role::orderBy('name')->pluck('name');

        return view('users.index', compact('users', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(Role::pluck('name')->all())],
        ]);

        // Admin tidak boleh mengubah role dirinya sendiri (mencegah terkunci dari sistem).
        if ($user->is($request->user())) {
            return back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        $user->syncRoles($data['role']);

        return back()->with('success', "Role {$user->name} diubah menjadi {$data['role']}.");
    }
}
