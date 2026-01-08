<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Get statistics for profile display
        $incomingTotal = IncomingLetter::count();
        $outgoingTotal = OutgoingLetter::count();
        $pendingApproval = IncomingLetter::whereIn('status', ['Baru', 'Menunggu'])->count();
        $inProgress = IncomingLetter::whereIn('status', ['Diproses'])->count();
        $incomingProcessed = IncomingLetter::whereIn('status', ['Diproses', 'Selesai'])->count();
        $pendingLetters = IncomingLetter::whereIn('status', ['Baru', 'Menunggu'])->count();
        $archivedCount = IncomingLetter::where('status', 'Selesai')->count();

        return view('profile.edit', [
            'user' => $user,
            'incomingTotal' => $incomingTotal,
            'outgoingTotal' => $outgoingTotal,
            'pendingApproval' => $pendingApproval,
            'inProgress' => $inProgress,
            'incomingProcessed' => $incomingProcessed,
            'pendingLetters' => $pendingLetters,
            'archivedCount' => $archivedCount,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
