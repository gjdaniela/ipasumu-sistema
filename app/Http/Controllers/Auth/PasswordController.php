<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Mail\ParolesNomaina;
use Illuminate\Support\Facades\Mail;
class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
        'current_password' => ['required', 'current_password'],
        'password' => ['required', Password::defaults(), 'confirmed'],
    ]);

    $user = $request->user();

    $user->update([
        'password' => Hash::make($validated['password']),
    ]);

    $data = [
        'epasts' => $user->email,
    ];

    Mail::to($user->email)->send(new ParolesNomaina($data));

    return back()->with('status', 'password-updated');
}
}
