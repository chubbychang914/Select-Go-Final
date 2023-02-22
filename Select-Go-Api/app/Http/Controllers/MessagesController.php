<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // ================================================================
    // 查詢全部留言 - index
    // ================================================================
    public function index()
    {
        // 在查詢的時候用 with() 可以一起將關聯的資料取出來
        $messages = Message::with('user')->get();

        return response($messages, Response::HTTP_OK);
    }

    // ================================================================
    // 查詢單一筆留言 - show
    // ================================================================
    public function show($messageId)
    {
        $message = Message::with('user')->findOrFail($messageId);

        return response($message, Response::HTTP_OK);
    }


    // =================================================================
    // Create steps:
    // 1. authenticate form
    // 2. make new msg
    // 3. return response
    // =================================================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:50',
            'content' => 'required|string|max:255'
        ]);

        $message = Auth::usermessage()->messages()->create($validated);

        return response($message, Response::HTTP_CREATED);
    }


    // =================================================================
    // Update steps:
    // 1. authenticate to make sure is logged in
    // 2. 建立指定 Message 的 model
    // 3. update msg
    // 4. return response
    // =================================================================
    public function update(Request $request, $messageId)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:50',
            'content' => 'required|string|max:255'
        ]);

        $message = Auth::user()->messages()->findOrFail($messageId);

        $message->update($validated);

        return response($message, Response::HTTP_OK);
    }


    // =================================================================
    // Delete steps:
    // 1. authenticate to make sure is logged in
    // 2. delete
    // 3. return response
    // =================================================================
    public function destroy($messageId)
    {
        $message = Auth::user()->messages()->findOrFail($messageId);

        $message->delete();

        return response([
            'message' => 'Post has been deleted!'
        ], Response::HTTP_OK);
    }

}