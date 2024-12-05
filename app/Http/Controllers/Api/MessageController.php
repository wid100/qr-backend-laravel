<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MessageRequest;
use App\Models\Admin\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function create(MessageRequest $request)
    {
        try {
            Message::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'message' => $request->message,
            ]);

            return response()->json(['message' => 'Your message has been sent.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'There was an error sending your message.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
