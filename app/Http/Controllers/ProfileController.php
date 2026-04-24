<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Province;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'provinces' => Province::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // VALIDASI TAMBAHAN (biodata)
        $request->validate([
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required|exists:regencies,id',
        ]);

        // update data basic (breeze)
        $user->fill($request->validated());

        // update biodata tambahan
        $user->update([
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui');
    }
    public function updateBiodata(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^[0-9]{10,12}$/'],
            'gender' => ['required'],
            'birth_date' => ['required', 'date'],
            'birth_place' => ['required'],
            'nationality' => ['required'],
            'marital_status' => ['required'],
            'religion' => ['required'],
            'address' => ['required'],
            'province_id' => ['required', 'exists:provinces,id'],
            'regency_id' => ['required', 'exists:regencies,id'],
        ]);

        $user = auth()->user();

        $user->update($request->only([
            'phone',
            'gender',
            'birth_date',
            'birth_place',
            'nationality',
            'marital_status',
            'religion',
            'address_ktp',
            'address',
            'district',
            'province_id',
            'regency_id'
        ]));

        return back()->with('success', 'Biodata berhasil disimpan');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
