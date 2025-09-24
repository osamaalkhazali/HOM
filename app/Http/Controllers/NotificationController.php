<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $notifications = DatabaseNotification::where('notifiable_id', $user->id)
      ->where('notifiable_type', get_class($user))
      ->orderByDesc('created_at')
      ->paginate(20);
    return view('notifications.index', compact('notifications'));
  }

  public function readAll()
  {
    $user = Auth::user();
    DatabaseNotification::where('notifiable_id', $user->id)
      ->where('notifiable_type', get_class($user))
      ->whereNull('read_at')
      ->update(['read_at' => now()]);
    return back()->with('success', 'All notifications marked as read');
  }

  public function open(string $id)
  {
    $user = Auth::user();
    $notification = DatabaseNotification::where('id', $id)
      ->where('notifiable_id', $user->id)
      ->where('notifiable_type', get_class($user))
      ->first();

    if (!$notification) {
      return redirect()->route('notifications.index')
        ->with('error', 'Notification not found.');
    }

    // Mark as read
    if (is_null($notification->read_at)) {
      $notification->update(['read_at' => now()]);
    }

    $data = (array) $notification->data;
    $link = $data['link'] ?? null;
    if ($link) {
      return redirect()->to($link);
    }

    return redirect()->route('notifications.index');
  }
}
