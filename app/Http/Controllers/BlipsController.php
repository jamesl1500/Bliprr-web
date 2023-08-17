<?php

namespace App\Http\Controllers;

use App\Models\Blip_likes;
use App\Models\Blip_reply;
use Illuminate\Http\Request;

use App\Models\Blips;

class BlipsController extends Controller
{
    // Create blips
    public function create(Request $request) {
        echo "ok";
        // Validate request
        $request->validate([
            'blip_content' => 'required|max:255'
        ]);

        // Create blip
        $blip = new Blips();

        // Set blip content
        $blip->blip_content = $request->input('blip_content');

        // Set blip author
        $blip->blip_author = auth()->user()->id;

        // Set blid uid
        $blip->buid = uniqid();

        // Set blip privacy
        $blip->blip_privacy = 1;

        // Set blip deleted
        $blip->blip_deleted = 0;

        // Save blip
        $blip->save();

        // Return to timeline
        return redirect()->route('timeline.index')->with('success', 'Blip created.');
    }

    // Delete blips
    public function delete(Request $request) {
        // Validate request
        $request->validate([
            'blip_id' => 'required'
        ]);

        // Get blip
        $blip = Blips::where('id', $request->input('blip_id'))->first();

        // Make sure blip exists
        if (!$blip) {
            // Return JSON response
            return response()->json([
                'status' => 'error',
                'message' => 'Blip does not exist.'
            ]);
        }

        // Make sure blip author is the current user
        if ($blip->blip_author != auth()->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not the author of this blip.'
            ]);
        }

        // Delete blip
        $blip->delete();

        // Return to timeline
        return response()->json([
            'status' => 'success',
            'message' => 'Blip deleted.'
        ]);
    }

    // Reply to blips
    public function reply(Request $request) {
        // Validate request
        $request->validate([
            'blip_id' => 'required',
            'blip_content' => 'required|max:255'
        ]);

        // Get blip
        $blip = Blips::where('id', $request->input('blip_id'))->first();

        // Make sure blip exists
        if (!$blip) {
            // Return JSON response
            return response()->json([
                'status' => 'error',
                'message' => 'Blip does not exist.'
            ]);
        }

        // Create reply
        $reply = new Blip_reply();

        // Set reply content
        $reply->reply_content = $request->input('blip_content');

        // Set reply author
        $reply->replyer_id = auth()->user()->id;

        $reply->note_id = 0;

        // Set reply uid
        $reply->ruid = uniqid();

        // Set reply parent
        $reply->buid = $blip->id;

        // Save reply
        $reply->save();

        // Get reply author name
        $reply_author = auth()->user()->name;

        // Return to timeline
        return response()->json([
            'status' => 'success',
            'message' => 'Reply created.',
            'reply_content' => $request->input('blip_content'),
            'reply_author_name' => ucwords(auth()->user()->name),
            'reply_author_username' => auth()->user()->username,
            'reply_author_avatar' => auth()->user()->profile_picture,
            'buid' => $request->input('blip_id'),
        ]);
    }

    // Like blips
    public function like(Request $request) {
        // Validate request
        $request->validate([
            'blip_id' => 'required'
        ]);

        // Get blip
        $blip = Blips::where('id', $request->input('blip_id'))->first();

        // Make sure blip exists
        if (!$blip) {
            // Return JSON response
            return response()->json([
                'status' => 'error',
                'message' => 'Blip does not exist.'
            ]);
        }

        // Make sure like doesn't already exist
        $like = Blip_likes::where('liker_id', auth()->user()->id)->where('buid', $blip->id)->first();

        // Make sure like doesn't already exist
        if ($like) {
            // Return JSON response
            return response()->json([
                'status' => 'error',
                'message' => 'You already liked this blip.'
            ]);
        }

        // Create like
        $like = new Blip_likes();

        // Set like author
        $like->liker_id = auth()->user()->id;

        // Set like uid
        $like->note_id = 0;

        // Set like parent
        $like->buid = $blip->id;

        // Save like
        $like->save();

        // Return to timeline
        return response()->json([
            'status' => 'success',
            'message' => 'Like created.'
        ]);
    }

    // Unlike blips
    public function unlike(Request $request) {
        // Validate request
        $request->validate([
            'blip_id' => 'required'
        ]);

        // Get blip
        $blip = Blips::where('id', $request->input('blip_id'))->first();

        // Make sure blip exists
        if (!$blip) {
            // Return JSON response
            return response()->json([
                'status' => 'error',
                'message' => 'Blip does not exist.'
            ]);
        }

        // Get like
        $like = Blip_likes::where('liker_id', auth()->user()->id)->where('buid', $blip->id)->first();

        // Make sure like exists
        if (!$like) {
            // Return JSON response
            return response()->json([
                'status' => 'error',
                'message' => 'You have not liked this blip.'
            ]);
        }

        // Delete like
        $like->delete();

        // Return to timeline
        return response()->json([
            'status' => 'success',
            'message' => 'Like deleted.'
        ]);
    }
}
