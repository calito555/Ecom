<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //

    //FUNCTION FOR USER ACCOUNT/DASHBOARD
    public function account()
    {
        if (Auth::user()){
            $user = Auth::user();
            return view('account.index');
        } else {
            return redirect('login');
        }
    }


    //FUNCTION FOR USER PROFILE
    public function profile()
    {
        $userId = auth()->id();

        $user = User::with(['profile', 'orders'])->findOrFail($userId);
        // $user = User::with('profile', 'orders')->find($userId);

        return view('account.profile', compact('user'));
    }


    public function saveProfile(Request $request)
    {
        $userId = auth()->id();

        // Validate the incoming request
        $validatedData = $request->validate([
            'profile_image' => 'required',
            'display_name' => 'required|string|max:255',
        ]);

        // Initialize the filename variable
        $filename = null;

        // Check if the user already has a profile
        $profileDetail = Profile::where('userId', $userId)->first();

        // Handle the profile image upload
        if ($request->hasFile('profile_image')) {
            // If a profile image already exists, delete the old one
            if ($profileDetail && $profileDetail->profile_image) {
                $oldImagePath = public_path('uploads/profile_image/' . $profileDetail->profile_image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            // Upload the new profile image
            $image = $request->file('profile_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile_image'), $filename);
        }

        // Find the user's profile details or create a new instance
        $profileDetail = Profile::updateOrCreate(
            ['userId' => $userId],
            [
                'display_name' => $validatedData['display_name'],
                'profile_image' => $filename, // Update the profile image path
            ]
        );

        // Save the profile details
        $profileDetail->save();


        return redirect()->back()->with("message", "Profile saved successfully.");
    }

    public function update_password()
    {
        return view('account.password_update');
    }

    protected function updateUserPassword(Request $request)
    {
        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with(['error' => "Incorrect Old Password"]);
        }
        if ($request->password !== $request->confirm_password) {
            return redirect()->back()->with(['error' => "Password Mismatch"]);
        } else {
            $password = Hash::make($request->password);
            $user = User::where("email", $user->email)->first();
            $user->update(['password' => $password]);
            return redirect()->back()->with(['message' => "Password Updated Successfully"]);
        }
    }
}
