<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Store chat messages
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255', // Adjust max length as needed
        ]);

        $chat = new Chat();
        $chat->user_id = Auth::id(); // Get the logged-in user's ID
        $chat->message = $request->message;
        $chat->save();

        return response()->json(['success' => true, 'chat' => $chat]);
    }

    // Get chat messages
    public function index()
    {
        $chats = Chat::where('user_id', Auth::id())->get(); // Get chats for the logged-in user
        return response()->json($chats);
    }

    // Handle image upload
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the max size as needed
        ]);

        if ($request->file('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('uploads', $imageName, 'public'); // Store in storage/app/public/uploads

            // Optionally, you can save the image path in the database if needed
            // $chat = new Chat();
            // $chat->user_id = Auth::id();
            // $chat->message = 'Image uploaded: ' . $imageName; // Store a message with the image info
            // $chat->save();

            return response()->json(['success' => 'Image uploaded successfully!', 'image' => $imageName]);
        }

        return response()->json(['error' => 'Image upload failed!'], 500);
    }
}
