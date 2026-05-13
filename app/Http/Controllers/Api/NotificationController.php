<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;
use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(10);
        return NotificationResource::collection($notifications);
    }


    public function markAsRead()
    {
        $user = auth()->user();
        $count = $user->unreadNotifications->count();
        $user->unreadNotifications->markAsRead();

        return response()->json([
            'success' => 'true',
            'total_read' => $count,
        ]);
    }
}
