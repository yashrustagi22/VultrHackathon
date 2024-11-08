<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;

class HomeController extends Controller
{
    public function index()
    {
        $chats = Chat::where('user_id', auth()->id())->latest()->get();

        return view('home', compact('chats'));
    }

    public function destroy($id)
    {
        $chat = Chat::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $chat->delete();

        return redirect()->route('home')->with('success', 'Chat deleted successfully.');
    }
}
