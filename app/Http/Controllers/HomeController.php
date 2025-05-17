<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request; // Import Request
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    public function homePage(Request $request)
    {
        $data = $this->userDashboardData($request);
        return view('home_user', $data);
    }

    public function index(Request $request)
    {
        if (auth()->user()->can('الاعدادات')) {
            return $this->adminDashboard();
        }
        return $this->userDashboard($request);
    }

    public function userDashboard(Request $request)
    {
        $data = $this->userDashboardData($request);
        return view('home_user', $data);
    }
    public function adminDashboard()
    {
        $data = $this->adminDashboardData();
        return view('home', $data);
    }

    private function userDashboardData(Request $request)
    {
        // إحصائيات أساسية

        $todayBookingsCount = Booking::whereDate('created_at', today())->count();
        $upcomingEventsCount = Event::where('date', '>=', now())->count();

        // الفعاليات المميزة
        $featuredEvents = Event::with('category')
            ->when(Schema::hasColumn('events', 'is_featured'), function ($query) {
                $query->where('is_featured', true);
            }, function ($query) {
                $query->latest();
            })
            ->where('date', '>=', now())
            ->limit(6)
            ->get();

        // البحث والتصفية
        $eventsQuery = Event::query()
            ->with('category')
            ->where('date', '>=', now())
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($request->date, function ($query, $date) {
                if ($date === 'today') {
                    $query->whereDate('date', today());
                } elseif ($date === 'week') {
                    $query->whereBetween('date', [now(), now()->addWeek()]);
                } elseif ($date === 'month') {
                    $query->whereBetween('date', [now(), now()->addMonth()]);
                } else {
                    $query->whereDate('date', $date);
                }
            })
            ->when($request->price, function ($query, $price) {
                if ($price === 'free') {
                    $query->where('price', 0);
                } elseif ($price === 'paid') {
                    $query->where('price', '>', 0);
                }
            })
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });

        // الترتيب
        if ($request->sort === 'popular') {
            $eventsQuery->withCount('bookings')->orderByDesc('bookings_count');
        } else {
            $eventsQuery->orderBy('date');
        }
        $upcomingEvents = Event::with('category') // optional if needed
            ->where('date', '>=', now())
            ->orderBy('date')
            ->limit(8)
            ->get();

        $featuredEventsCount = Event::where('date', '>=', now())
            ->when(Schema::hasColumn('events', 'is_featured'), function ($query) {
                $query->where('is_featured', true);
            })
            ->count();

        $events = $eventsQuery->paginate(9);
        $categories = Category::withCount('events')->paginate(18); // 12 عنصر في الصفحة
        $totalEventsCount = Event::count();
        $totalUsersCount = User::count();
        $totalBookingsCount = Booking::count();
        $user_id = Auth::id();

        return [
            'featuredEvents' => $featuredEvents,
            'recentEvents' => $todayBookingsCount,
            'todayBookingsCount' => $todayBookingsCount,
            'upcomingEventsCount' => $upcomingEventsCount,
            'categories' => $categories,
            'popularEvents' => $events,
            'events' => $events,
            'totalEventsCount' => $totalEventsCount,
            'upcomingEvents' => $upcomingEvents,
            'totalUsersCount' => $totalUsersCount,
            'totalBookingsCount' => $totalBookingsCount,
            'featuredEventsCount' => $featuredEventsCount,
            'is_admin' => false,
            'searchQuery' => $request->only(['category', 'date', 'price', 'search', 'sort']),
            'user_id' => $user_id
        ];
    }

    private function adminDashboardData()
    {
        $stats = [
            'total_events' => Event::count(),
            'upcoming_events' => Event::where('date', '>=', now())->count(),
            'past_events' => Event::where('date', '<', now())->count(),
            'active_bookings' => Booking::count(),
            'today_bookings' => Booking::whereDate('created_at', today())->count(),
            'total_users' => User::count(),
            'active_users' => User::has('bookings')->count(),
        ];

        $popularEvents = Event::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->limit(5)
            ->get();

        $topEvent = $popularEvents->first();
        $stats['top_event'] = $topEvent ? $topEvent->title : 'N/A';
        $stats['top_event_bookings'] = $topEvent ? $topEvent->bookings_count : 0;

        return [
            'stats' => $stats,
            'upcomingEvents' => $this->getUpcomingEvents(),
            'popularEvents' => $popularEvents,
            'recentBookings' => $this->getRecentBookings(),
            'activeUsers' => $this->getActiveUsers(),
            'eventsChart' => $this->getEventsChart(),
            'bookingAnalysis' => $this->getBookingAnalysis(),
            'eventAnalysis' => $this->getEventAnalysis(),
            'is_admin' => true
        ];
    }

    private function getEventAnalysis()
    {
        return [
            'by_category' => Category::withCount('events')->get(),
            'upcoming_by_venue' => Event::where('date', '>=', now())
                ->select('venue', DB::raw('COUNT(*) as count'))
                ->groupBy('venue')
                ->orderByDesc('count')
                ->get(),
            'price_stats' => [
                'average' => Event::avg('price'),
                'max' => Event::max('price'),
                'min' => Event::min('price')
            ]
        ];
    }

    private function getBookingAnalysis()
    {
        return [
            'daily_trend' => Booking::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                ->whereBetween('created_at', [now()->subDays(30), now()])
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            'by_event' => Event::withCount('bookings')->orderByDesc('bookings_count')->limit(5)->get(),
            'by_user' => User::withCount('bookings')->orderByDesc('bookings_count')->limit(5)->get()
        ];
    }

    private function getActiveUsers()
    {
        return User::withCount('bookings')
            ->with(['bookings' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->orderByDesc('bookings_count')
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'bookings_count' => $user->bookings_count,
                    'last_booking_date' => $user->bookings->first() ? $user->bookings->first()->created_at->format('d/m/Y') : 'N/A'
                ];
            });
    }

    private function getUpcomingEvents()
    {
        return Event::where('date', '>=', now())
            ->orderBy('date')
            ->limit(5)
            ->get();
    }

    private function getRecentBookings()
    {
        return Booking::with('event')
            ->latest()
            ->limit(5)
            ->get();
    }

    private function getEventsChart()
    {
        $categories = Category::withCount('events')->get();

        $chart = app()->chartjs
            ->name('eventsChart')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($categories->pluck('name')->toArray())
            ->datasets([
                [
                    "label" => "عدد الفعاليات حسب الفئة",
                    'backgroundColor' => ['#6777ef', '#ffa426', '#fc544b', '#63ed7a', '#6777ef'],
                    'data' => $categories->pluck('events_count')->toArray()
                ]
            ]);

        return $chart;
    }
}
