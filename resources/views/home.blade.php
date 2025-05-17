@if ($is_admin)
    <!-- محتوى لوحة الإدارة -->
    @include('admin_dashboard_content')
@else
    <!-- محتوى لوحة المستخدم -->
    @include('home_user', [
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
            'searchQuery' => $request->only(['category', 'date', 'price', 'search', 'sort'])
    ])
@endif
