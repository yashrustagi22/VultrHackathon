<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Chat;
use App\Models\Message;

class ChatbotController extends Controller
{
    // Display chat form and chats for authenticated users
    public function showChatForm()
    {
        if (!auth()->check()) {
            return redirect('/welcome')->withErrors('You must be logged in to access the chat.');
        }

        $chats = Chat::where('user_id', auth()->id())->latest()->get();
        return view('chatbot', compact('chats'));
    }

    // Handle prescription upload and text extraction
    public function uploadPrescription(Request $request)
{
    Log::info('Received prescription upload request.');

    // Validate the uploaded file
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    Log::info('File validation passed.');

    // Add logging to check if the image is available
    if ($request->hasFile('image')) {
        Log::info('Image file is present.');
    } else {
        Log::error('Image file is not present in the request.');
        return response()->json(['error' => 'Image file is required.'], 400);
    }

    try {
        // Get the path of the uploaded file
        $imagePath = $request->file('image')->getPathname();
        Log::info('Image path retrieved: ' . $imagePath);

        // Perform OCR by sending the file to the OCR service
        $ocrResponse = Http::attach(
            'image', file_get_contents($imagePath), 'prescription.jpg'
        )->post('http://flask-ocr-app:5000/predict');

        Log::info('OCR service response: ' . $ocrResponse->body());

        if ($ocrResponse->failed()) {
            Log::error('OCR processing failed.', ['response' => $ocrResponse->body()]);
            return response()->json(['error' => 'OCR processing failed: ' . $ocrResponse->body()], 500);
        }

        // Extract text from the OCR response
        $extractedText = $ocrResponse->json()['text'] ?? '';
        Log::info('Extracted text from OCR response: ' . $extractedText);

        if (empty($extractedText)) {
            Log::warning('No text found in the OCR response.');
            return response()->json(['error' => 'No text found in the OCR response.'], 400);
        }

        // Retrieve the chat title from the session
        $title = session('chat_title');
        Log::info('Retrieved chat title from session: ' . $title);

        if (empty($title)) {
            Log::error('Chat title is missing in session.');
            return response()->json(['error' => 'Chat title is missing. Please enter a title.'], 400);
        }

        // Create new chat with the title and extracted text
        $chat = Chat::create([
            'user_id' => Auth::id(),
            'title' => $title,
            'content' => $extractedText,
        ]);

        Log::info('Chat created successfully', ['chat_id' => $chat->id]);

        // Clear the session title after use
        session()->forget('chat_title');

        // Return the extracted text in the response
        return response()->json(['text' => $extractedText]);
    } catch (\Exception $e) {
        Log::error('An error occurred during prescription upload.', ['message' => $e->getMessage()]);
        return response()->json([
            'error' => 'An unexpected error occurred: ' . $e->getMessage()
        ], 500);
    }
}




    public function storeChatTitle(Request $request)
    {
        $request->validate(['chatTitle' => 'required|string|max:255']);
        session(['chat_title' => $request->chatTitle]);

        return redirect()->route('chat.form');
    }


    // Show a specific chat with messages
    public function show($chatId)
    {
        $chat = Chat::where('id', $chatId)->where('user_id', auth()->id())->firstOrFail();
        return view('chat.show', compact('chat')); // Pass both variables to the view
    }


    // Delete a specific chat
    public function destroy($id)
    {
        $chat = Chat::where('id', $id)->where('user_id', '=', auth()->id())->firstOrFail();
        $chat->delete();

        return redirect()->route('home')->with('status', 'Chat deleted successfully.');
    }

}
