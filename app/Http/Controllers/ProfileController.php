<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request): View
    {
        $data['regions'] = Region::all();
        $data['user'] = $request->user();
        return view('profile.show', $data);
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, string $id)
    {
        //
        try{

            $user = User::findOrFail($id);

            User::where('id', $user->id)->update([
                'fname' => $request->fname,
                'mname' => $request->mname,
                'lname' => $request->lname,
                'phone' => $request->phone,
                'email' => $request->email,
                // 'position' => $request->position,
                'address' => $request->address,
                'region_id' => $request->region,
                'district_id' => $request->district,
                'gender' => $request->gender,
                'merital_status' => $request->marital_status,
            ]);
            return back()->with('success', 'Your Profile has updated successfully!');
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while updating the user. ' . $e->getMessage(),
            ]);
        }

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

    public function change_password()
    {
        return view('profile.partials.update-password-form');
    }

    public function save_new_password(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $current_password = $user->password;

        if (Hash::check($request->current_password, $current_password)) {
            $user->password = Hash::make($request->password);
            $user->password_set = 1;
            $user->save();

            Auth::logout();

            return redirect()->route('login')->with('password_set', 'Password changed successfully. Please login with your new password.');
        } else {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }
    }
}
