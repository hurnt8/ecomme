<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        $orders = auth()->user()->orders()->with('items')->latest()->paginate(10);

        return view('shop.account.index', ['orders' => $orders]);
    }

    public function editProfile(): View
    {
        return view('shop.account.profile');
    }

    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->name = $request->validated('name');
        $user->email = $request->validated('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->validated('password'));
        }

        $user->save();

        return redirect()->route('account.profile')->with('toast', [
            'message' => 'Ihr Profil wurde aktualisiert.',
            'type' => 'success',
        ]);
    }
}
