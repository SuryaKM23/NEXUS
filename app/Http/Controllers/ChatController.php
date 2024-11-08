<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function redirectToChatify($id)
    {
        // Pass the user ID to the view
        return view('Chatify::pages.app', ['userId' => $id]);
    }
}

