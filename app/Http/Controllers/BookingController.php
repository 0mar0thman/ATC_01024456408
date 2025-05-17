<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use App\Notifications\NoteInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingsExport;
use App\Notifications\BookingConfirmed;
use Illuminate\Support\Facades\Notification;
use \Illuminate\Notifications\DatabaseNotification;

class BookingController extends Controller
{
    /**
     * عرض قائمة جميع الحجوزات
     */
    public function index()
    {
        $bookings = Booking::with(['event', 'user'])->latest()->get();
        return view('bookings.booking', compact('bookings'));
    }

    /**
     * عرض نموذج إنشاء حجز عام
     */
    public function create()
    {
        $events = Event::upcoming()->get();
        $users = User::all();
        return view('bookings.create', compact('events', 'users'));
    }

    /**
     * عرض نموذج إنشاء حجز لحدث معين
     */
    public function createForEvent($event_id)
    {
        $event = Event::findOrFail($event_id);
        return view('bookings.create-for-event', compact('event'));
    }

    /**
     * تخزين حجز جديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
            'tickets' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        // التحقق من توفر المقاعد
        $event = Event::find($request->event_id);
        if ($event->available_seats < $request->tickets) {
            return back()->withErrors(['tickets' => 'لا توجد مقاعد كافية متاحة'])->withInput();
        }

        $booking = Booking::create([
            'event_id' => $request->event_id,
            'user_id' => $request->user_id,
            'tickets' => $request->tickets,
            'status' => 'confirmed',
            'notes' => $request->notes,
            'booked_by' => Auth::id(),
        ]);

        // إرسال إشعار للمستخدم
        $user = User::find($request->user_id);
        $user->notify(new NoteInvoice($booking));

        session()->flash('success', 'تم إنشاء الحجز بنجاح');
        return redirect()->route('bookings.show', $booking->id);
    }

    /**
     * عرض تفاصيل حجز معين
     */
    public function show($id)
    {
        $booking = Booking::with(['event', 'user'])->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    /**
     * عرض نموذج تعديل الحجز
     */
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $events = Event::upcoming()->get();
        $users = User::all();
        return view('bookings.edit', compact('booking', 'events', 'users'));
    }

    /**
     * تحديث الحجز في قاعدة البيانات
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
            'tickets' => 'required|integer|min:1',
            'status' => 'required|in:confirmed,cancelled,completed',
            'notes' => 'nullable|string|max:500',
        ]);

        $booking = Booking::findOrFail($id);

        // التحقق من توفر المقاعد إذا تم تغيير الحدث أو عدد التذاكر
        if ($request->event_id != $booking->event_id || $request->tickets != $booking->tickets) {
            $event = Event::find($request->event_id);
            $availableSeats = $event->available_seats + $booking->tickets; // نعيد المقاعد القديمة

            if ($availableSeats < $request->tickets) {
                return back()->withErrors(['tickets' => 'لا توجد مقاعد كافية متاحة'])->withInput();
            }
        }

        $booking->update([
            'event_id' => $request->event_id,
            'user_id' => $request->user_id,
            'tickets' => $request->tickets,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        session()->flash('success', 'تم تحديث الحجز بنجاح');
        return redirect()->route('bookings.show', $booking->id);
    }

    /**
     * إلغاء الحجز (Soft Delete)
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        // يمكنك إضافة شروط إضافية هنا لمنع الحذف في حالات معينة
        if ($booking->status == 'completed') {
            session()->flash('error', 'لا يمكن حذف حجز مكتمل');
            return back();
        }

        $booking->delete();

        session()->flash('success', 'تم إلغاء الحجز بنجاح');
        return redirect()->route('bookings.index');
    }

    /**
     * تصدير الحجوزات إلى Excel
     */
    public function export()
    {
        return Excel::download(new BookingsExport, 'bookings.xlsx');
    }

    /**
     * تأكيد الحجز
     */
    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'confirmed']);

        // إرسال إشعار التأكيد
        $booking->user->notify(new NoteInvoice($booking));

        session()->flash('success', 'تم تأكيد الحجز بنجاح');
        return back();
    }

    /**
     * إلغاء الحجز
     */
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'cancelled']);

        session()->flash('success', 'تم إلغاء الحجز بنجاح');
        return back();
    }

    /**
     * عرض حجوزات مستخدم معين
     */
    public function userBookings($user_id)
    {
        $user = User::findOrFail($user_id);
        $bookings = $user->bookings()->with('event')->latest()->get();

        return view('bookings.user-bookings', compact('user', 'bookings'));
    }

    /**
     * عرض حجوزات فعالية معينة
     */
    public function eventBookings($event_id)
    {
        $event = Event::findOrFail($event_id);
        $bookings = $event->bookings()->with('user')->latest()->get();

        return view('bookings.event-bookings', compact('event', 'bookings'));
    }

    public function note($id)
    {
        $booking = Booking::with('event', 'event.category')->findOrFail($id);

        return view('layouts.sidebar', compact('booking'));
    }
}
