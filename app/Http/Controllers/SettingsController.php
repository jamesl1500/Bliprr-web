<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class SettingsController extends Controller
{
    // Save basic information for the user
    public function saveBasicInfo(Request $request)
    {
        // Get the user's ID
        $user_id = $request->user()->id;

        // Get the user's information
        $user = User::find($user_id);

        // Validate the user's information
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user_id . ',id',
            'bio' => 'required'
        ]);
        
        // Update the user's information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;

        // Save the user's information
        $user->save();

        // Redirect the user back to the settings page with a success message
        return redirect()->route('settings.index')->with('success', 'Your information has been updated successfully.');
    }

    // Save the user's profile picture
    public function saveProfilePicture(Request $request)
    {
        // Get the user's ID
        $user_id = $request->user()->id;

        // Get the user's information
        $user = User::find($user_id);

        // Validate the user's information
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        // Get the user's profile picture
        $profile_picture = $request->file('profile_picture');

        // Get the profile picture's name
        $profile_picture_name = time() . '.' . $profile_picture->extension();

        // Move the profile picture to the public folder
        $profile_picture->move(public_path('usr_data'), $profile_picture_name);

        // Update the user's profile picture
        $user->profile_picture = $profile_picture_name;

        // Save the user's information
        $user->save();

        // Redirect the user back to the settings page with a success message
        return redirect()->route('settings.index')->with('success', 'Your profile picture has been updated successfully.');
    }
}
