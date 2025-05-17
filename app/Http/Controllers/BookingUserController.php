<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\NoteInvoice;
use Illuminate\Support\Facades\Notification;

class BookingUserController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');

        $query = Auth::user()->bookings()
            ->whereHas('event')
            ->with('event');

        if ($status !== 'all' && \Schema::hasColumn('bookings', 'status')) {
            $query->where('status', $status);
        }

        $bookings = $query->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('bookings_user.index', compact('bookings', 'status'));
    }

    public function create($id)
    {
        // if ($event->date < now()) {
        //     return redirect()->back()->with('error', 'لا يمكن حجز فعالية منتهية');
        // }

        // if ($event->available_seats <= 0) {
        //     return redirect()->back()->with('error', 'لا توجد مقاعد متاحة');
        // }

        $event = Event::findOrFail($id);
        return view('bookings_user.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'tickets' => 'required|integer|min:1|max:' . $event->capacity,
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer'
        ]);

        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->event_id = $event->id;
        $booking->tickets = $request->tickets;
        $booking->status = 'confirmed';
        $booking->payment_method = $request->payment_method;;
        $booking->save();

        // تحديث المقاعد المتاحة
        $event->decrement('capacity', $request->tickets);

        // إرسال إشعار للمستخدم
        $user = Auth::user();
        if ($user) {
            Notification::send($user, new NoteInvoice($booking));
        }

        return redirect()->route('user.bookings.show', $booking)
            ->with('success', 'تم حجز الفعالية بنجاح');
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id != Auth::id()) {
            abort(403);
        }

        return view('bookings_user.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id != Auth::id()) {
            abort(403);
        }

        if ($booking->event->date < now()->addDays(2)) {
            return redirect()->back()->with('error', 'لا يمكن الإلغاء قبل 48 ساعة من الفعالية');
        }

        $booking->status = 'cancelled';
        $booking->save();

        // إعادة المقاعد المتاحة
        $booking->event->increment('available_seats', $booking->tickets_count);

        return redirect()->route('user.bookings.index')
            ->with('success', 'تم إلغاء الحجز بنجاح');
    }

    public function download(Booking $booking)
    {
        // التحقق من أن الحجز للمستخدم الحالي
        if ($booking->user_id != auth()->id()) {
            abort(403);
        }

        // التحقق من أن الحجز مؤكد
        if ($booking->status != 'confirmed') {
            return back()->with('error', 'لا يمكن تحميل تذكرة غير مؤكدة');
        }

        // إنشاء محتوى التذكرة (يمكن استبدال هذا بإنشاء PDF فعلي)
        $content = view('bookings_user.ticket', compact('booking'))->render();

        // إرجاع الاستجابة للتحميل
        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, 'تذكرة-' . $booking->id . '.html'); // يمكن تغيير الامتداد لـ .pdf إذا كنت تستخدم مكتبة PDF
    }
}
