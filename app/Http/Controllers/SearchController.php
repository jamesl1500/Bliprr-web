<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    // Search index page
    public function index(Request $request)
    {
        // See if the user is searching for something
        if ($request->input('search')) {
            $search = $request->input('search');

            // Search for users with the search term in their name or username
            $users = DB::table('users')->where('name', 'LIKE', "%{$search}%")
                                       ->orWhere('username', 'LIKE', "%{$search}%")
                                       ->get();
            
            // Searchh for blips with the search term in their content  
            $blips = DB::table('blips')->where('blip_content', 'LIKE', "%{$search}%")
                                       ->get();

            return view('pages.search', ['users' => $users, 'blips' => $blips, 'search' => $search]);
        }

        return view('pages.search');
    }
}
