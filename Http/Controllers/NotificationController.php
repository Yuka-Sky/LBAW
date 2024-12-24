<?php

namespace App\Http\Controllers;

use App\Models\PostNotification;
use App\Models\CommentNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function show()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Precisas estar autenticado para aceder a esta página.');
        }

        $userId = auth()->id();
        $postNotifications = PostNotification::where('id_user_notified', $userId)->get();
        $commentNotifications = CommentNotification::where('id_user_notified', $userId)->get();
        $allNotifications = $postNotifications->merge($commentNotifications);
        $allNotifications = $allNotifications->sortByDesc('date');

        return view('pages.notifications', compact('allNotifications'));
    }
}