<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class FollowingsController extends Controller
{
    // Follow a user
    public function follow(Request $request)
    {
        // Make sure user_id exists
        if (!User::where('id', $request->user_id)->exists()) {
            return back()->with('error', 'User does not exist.');
        }

        // Get the user's ID
        $user_id = $request->user_id;

        // Make sure the user is not trying to follow themselves
        if (Auth::user()->id == $request->user_id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        // Make sure the user is not already following the user
        if (User::find(Auth::user()->id)->followings->contains('followee_id', $request->user_id)) {
            return back()->with('error', 'You are already following this user.');
        }

        echo $request->user_id;
        echo Auth::user()->id;

        // Follow the user
        DB::table('followings')->insert([
            'fuid' => md5(uniqid(rand(), true)),
            'followee_id' => $request->user_id,
            'follower_id' => Auth::user()->id,
            'note_id' => '',
        ]);

        // Redirect the user back to the timeline with a success message
        return back()->with('success', 'You are now following this user.');
    }

    // Unfollow a user
    public function unfollow(Request $request)
    {
        // Make sure user_id exists
        if (!User::where('id', $request->user_id)->exists()) {
            return back()->with('error', 'User does not exist.');
        }

        // Get the user's ID
        $user_id = $request->user_id;

        // Make sure the user is not trying to unfollow themselves
        if (Auth::user()->id == $request->user_id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        // Make sure the user is already following the user
        if (!User::find(Auth::user()->id)->followings->contains('followee_id', $request->user_id)) {
            return back()->with('error', 'You are not following this user.');
        }

        // Unfollow the user
        DB::table('followings')->where('followee_id', $request->user_id)->where('follower_id', Auth::user()->id)->delete();

        // Redirect the user back to the timeline with a success message
        return back()->with('success', 'You have unfollowed this user');
    }
}
