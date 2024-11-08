<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Auth;

// Default route to welcome page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication routes
Auth::routes();

// Chatbot routes - requires user authentication
Route::middleware(['auth'])->group(function () {

    // Home route after login
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::post('/chat/submit-title', [ChatbotController::class, 'submitChatTitle'])->name('chat.submitTitle');

    // Route to show the chat form
    Route::get('/chat', [ChatbotController::class, 'showChatForm'])->name('chat.form');

    // Route to store a new chat with a title
    Route::post('/chat/store', [ChatbotController::class, 'storeChatTitle'])->name('chat.store');

    // Route to upload prescription
    Route::post('/upload-prescription', [ChatbotController::class, 'uploadPrescription'])->name('chat.upload');

    // Route to show a specific chat
    Route::get('/chat/{chat}', [ChatbotController::class, 'show'])->name('chat.show');

    // Route to delete a chat
    Route::delete('/chat/{chat}', [ChatbotController::class, 'destroy'])->name('chat.destroy');

    // Logout route with redirection to welcome page
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('welcome'); // Redirect to the welcome page
    })->name('logout');
});
