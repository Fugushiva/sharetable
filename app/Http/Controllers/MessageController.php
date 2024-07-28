<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $threads = Thread::forUser(Auth::id())->latest('updated_at')->get();

        foreach ($threads as $thread) {
            $thread->unread_count = $thread->unreadMessagesCount(Auth::id());
        }

        return view('conversations.index', compact('threads'));
    }

    public function createForm(Request $request)
    {
        $recipient = User::findOrFail($request->recipient_id);

        return view('conversations.create', compact('recipient'));
    }

    public function createConversation(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'body' => 'required|string',
        ]);

        $thread = Thread::create([
            'subject' => 'Conversation entre ' . Auth::user()->firstname . ' et ' . User::find($validated['recipient_id'])->firstname,
        ]);

        $message = Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $validated['body'],
            'is_read' => false,
        ]);

        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'last_read' => now(),
        ]);

        $thread->addParticipant($validated['recipient_id']);

        return redirect()->route('conversations.show', $thread->id)
            ->with('success', 'Conversation créée avec succès.');
    }

    public function show($threadId)
    {
        $thread = Thread::findOrFail($threadId);

        $this->authorize('view', $thread);

        $messages = $thread->messages()->latest()->get();

        foreach ($messages as $message) {
            if ($message->user_id != Auth::id() && $message->is_read == false) {
                $message->is_read = true;
                $message->save();
                // Ajoutez un message de débogage
                Log::info('Message marqué comme lu : ' . $message->id);
            }
        }

        return view('conversations.show', compact('thread', 'messages'));
    }

    public function replyToConversation(Request $request, $threadId)
    {
        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $thread = Thread::findOrFail($threadId);
        $thread->activateAllParticipants();

        $message = Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $validated['body'],
            'is_read' => false,
        ]);

        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
        ]);
        $participant->last_read = now();
        $participant->save();

        return redirect()->route('conversations.show', $thread->id)
            ->with('success', 'Message envoyé avec succès.');
    }
}




