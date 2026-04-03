<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkShareController extends Controller
{
    public function share(Request $request, Link $link)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'permession' => 'required|in:view,edit'
        ]);

        $userToShareWith = User::where('email', $request->email)->firstOrFail();

        if ($userToShareWith->id === Auth::id()) {
            return back()->with('error', 'You cannot share the link with yourself!');
        }

        $link->sharedWithUsers()->syncWithoutDetaching([
            $userToShareWith->id => ['permession' => $request->permession]
        ]);

        return back()->with('success', 'Link shared successfully with ' . $userToShareWith->name);
    }

    public function sharedWithMe()
    {
        $user = Auth::user();
        $links = $user->sharedLinks()->with('user')->get();

        return view('links.shared', compact('links'));
    }
}