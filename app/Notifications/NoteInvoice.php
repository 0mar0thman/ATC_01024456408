<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;
use App\Models\Event;

use Illuminate\Support\Facades\Auth;

class NoteInvoice extends Notification
{
    private  $bookings;
    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $bookings)
    {
        $this->bookings = $bookings;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        try {
            return ['mail', 'database'];
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $event = Event::find($this->bookings['Booking_id']);
        return (new MailMessage)
            ->subject('الحجز رقم: ' . $this->bookings['id'])
            ->markdown('emails.bookings_notification', [
                'bookings' => $this->bookings,
                'user' => $notifiable,
                'data' => [
                    'booking_id' => $this->bookings['id'],
                    'tickets' => $this->bookings['tickets'],
                    'user_send' => Auth::user()->name,
                    'status' => $this->bookings['status'],
                    'price' => $this->bookings->event->price,
                    'place' => $this->bookings->event->venue,
                    'img' => $this->bookings->event->image,
                    'booking_created_at' => $this->bookings->created_at,
                    'event_date' => $this->bookings->event->date,
                    'event_name' => $this->bookings->event->title,
                    'category_name' => $this->bookings->event->category->name,
                    'event' => $event
                ]
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */

    public function toDatabase()
    {
        return [
            'booking_id' => $this->bookings->id,
            'category_name' => $this->bookings->event->category->name ?? 'غير محدد',
            'event_name' => $this->bookings->event->title ?? 'غير محدد',
            'price' => $this->bookings->event->price ?? 0,
            'user_send' => Auth::user()->name ?? 'النظام'
        ];
    }
}
