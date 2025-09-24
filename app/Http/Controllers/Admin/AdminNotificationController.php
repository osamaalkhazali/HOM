<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class AdminNotificationController extends Controller
{
  public function index()
  {
    $admin = Auth::guard('admin')->user();
    $notifications = DatabaseNotification::where('notifiable_id', $admin->id)
      ->where('notifiable_type', get_class($admin))
      ->orderByDesc('created_at')
      ->paginate(20);
    return view('admin.notifications.index', compact('notifications'));
  }

  public function readAll()
  {
    $admin = Auth::guard('admin')->user();
    DatabaseNotification::where('notifiable_id', $admin->id)
      ->where('notifiable_type', get_class($admin))
      ->whereNull('read_at')
      ->update(['read_at' => now()]);
    return back()->with('success', 'All notifications marked as read');
  }

  public function open(string $id)
  {
    $admin = Auth::guard('admin')->user();
    $notification = DatabaseNotification::where('id', $id)
      ->where('notifiable_id', $admin->id)
      ->where('notifiable_type', get_class($admin))
      ->first();

    if (!$notification) {
      return redirect()->route('admin.notifications.index')
        ->with('error', 'Notification not found.');
    }

    if (is_null($notification->read_at)) {
      $notification->update(['read_at' => now()]);
    }

    $data = (array) $notification->data;
    $link = $data['link'] ?? null;
    if ($link) {
      return redirect()->to($link);
    }

    return redirect()->route('admin.notifications.index');
  }
}
