<?php

namespace App\Http\Controllers\Chats;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chats\MessageRequest;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $chats = Chat::query()->when($request->branch_id, function ($query) use ($request) {
            $query->where('branch_id', $request->branch_id);
        })->when($request->user_id, function ($query) use ($request) {
            $query->where('user_id', $request->user_id);
        })->with(['user', 'messages' => function ($query) {
            $query->latest()->limit(1);
        }])->get();

        return contentResponse($chats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request)
    {
        $chat = Chat::firstOrCreate($request->safe()->only(['branch_id', 'user_id']));
        $message = Message::create($request->validated() + ['chat_id' => $chat->id]);
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        return contentResponse($chat->load('user', 'messages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        $chat->forceDelete();
        return messageResponse();
    }
}