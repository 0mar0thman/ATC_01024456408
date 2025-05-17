<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Event;
use App\Models\Booking;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.main-header', 'layouts.main-sidebar'], function ($view) {
            $todayBookingsCount = Booking::whereDate('created_at', today())->count();
            $upcomingEventsCount = Event::where('date', '>=', now())->count();
            $categories_count = Category::count();
            $categories = Category::all();
            $BookingsCount = Booking::count();
            $bookings = Auth::user()->bookings()
                ->with('event')
                ->latest()->count();

            $view->with([
                'upcomingEventsCount' => $upcomingEventsCount,
                'todayBookingsCount' => $todayBookingsCount,
                'categories_count' => $categories_count,
                'categories' => $categories,
                'BookingsCount' => $BookingsCount,
                'bookings' => $bookings,
            ]);
        });
    }
}
