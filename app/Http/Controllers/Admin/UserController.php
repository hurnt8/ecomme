<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Staff accounts only. Customers are deliberately out of scope: the shop has thousands of them,
 * they sign themselves up, and mixing them into this screen would turn a short team roster into
 * a paginated customer list where a misplaced click grants back-office access.
 */
class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()
                ->whereIn('role', array_column(UserRole::staff(), 'value'))
                ->orderBy('name')
                ->get(),
            'customerCount' => User::query()->where('role', UserRole::Customer)->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'user' => new User,
            'roles' => UserRole::staff(),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = new User([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
            'role' => $request->validated('role'),
        ]);

        // Assigned outside the fillable array on purpose: email_verified_at is not mass-assignable
        // — deliberately so, since it must never be settable from request input. An admin creating
        // the account already knows who this is, so there is no address to confirm.
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('admin.utilisateurs.index')->with('status', 'Utilisateur créé.');
    }

    public function edit(User $user): View
    {
        $this->assertStaff($user);

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => UserRole::staff(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->assertStaff($user);
        $this->assertNotLastAdmin($user, $request->validated('role'));

        $user->fill([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'role' => $request->validated('role'),
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->validated('password'));
        }

        $user->save();

        return redirect()->route('admin.utilisateurs.index')->with('status', 'Utilisateur mis à jour.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->assertStaff($user);

        if ($user->is(request()->user())) {
            return back()->withErrors(['user' => 'Vous ne pouvez pas supprimer votre propre compte.']);
        }

        $this->assertNotLastAdmin($user, UserRole::Customer->value);

        $user->delete();

        return redirect()->route('admin.utilisateurs.index')->with('status', 'Utilisateur supprimé.');
    }

    /**
     * Route-model binding resolves any user id, including a customer's. Without this a crafted
     * URL would open a customer in the staff editor and let them be handed a role.
     */
    private function assertStaff(User $user): void
    {
        abort_unless($user->isStaff(), 404);
    }

    /**
     * Demoting or deleting the only administrator would lock everyone out of the back-office,
     * with no way back in short of editing the database by hand.
     */
    private function assertNotLastAdmin(User $user, string $newRole): void
    {
        if (! $user->isAdmin() || $newRole === UserRole::Admin->value) {
            return;
        }

        $otherAdmins = User::query()
            ->where('role', UserRole::Admin)
            ->whereKeyNot($user->getKey())
            ->count();

        abort_if($otherAdmins === 0, 422, 'Impossible : ce compte est le dernier administrateur.');
    }
}
