<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessagingController extends Controller
{
    /**
     * Display a list of conversations for the authenticated user.
     */
    public function index()
    {
        $user = Auth::user();
        $conversations = Message::where('sender_id', $user->id)
                                ->orWhere('receiver_id', $user->id)
                                ->with(['sender', 'receiver'])
                                ->latest()
                                ->get()
                                ->unique(function ($message) {
                                    return collect([$message->sender_id, $message->receiver_id])->sort()->values()->all();
                                });

        return view('messages.index', compact('conversations'));
    }

    /**
     * Show messages in a specific conversation.
     */
    public function show($userId)
    {
        $currentUser = Auth::user();
        $otherUser = User::findOrFail($userId);

        $messages = Message::where(function ($query) use ($currentUser, $otherUser) {
                            $query->where('sender_id', $currentUser->id)
                                  ->where('receiver_id', $otherUser->id);
                        })
                        ->orWhere(function ($query) use ($currentUser, $otherUser) {
                            $query->where('sender_id', $otherUser->id)
                                  ->where('receiver_id', $currentUser->id);
                        })
                        ->orderBy('created_at', 'asc')
                        ->get();

        return view('messages.show', compact('messages', 'otherUser'));
    }

    /**
     * Send a new message to another user.
     */
    public function send(Request $request, $userId)
    {
        $currentUser = Auth::user();
        $receiver = User::findOrFail($userId);

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => $currentUser->id,
            'receiver_id' => $receiver->id,
            'content' => $request->message,
        ]);

        // Optionally, notify the receiver about the new message

        return redirect()->route('messages.show', $receiver->id)->with('success', 'Message sent successfully.');
    }
}