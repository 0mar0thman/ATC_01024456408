<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{

    public function read($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        // تعليم كمقروء
        if ($notification->unread()) {
            $notification->markAsRead();
        }

        // تحويل المستخدم إلى صفحة الفاتورة
        $Booking_id = $notification->data['booking_id'] ?? null;

        if ($Booking_id) {
            return redirect()->route('booking.details', $Booking_id);
        }

        return redirect()->back()->with('error', 'Booking not found.');
    }

    public function markAll()
    {
        DatabaseNotification::whereNull('read_at')->latest()->get()->markAsRead();
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
}
