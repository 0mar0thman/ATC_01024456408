<link href="{{ URL::asset('assets/css/layouts/main-header.css') }}" rel="stylesheet" />
<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">

        <!-- الاعدادات -->
        <div class="main-header-left ">
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>
        </div>
        <!-- البحث -->
        {{-- @if (Auth::user()->is_admin == 0 ?? '') --}}
        <form class="form" action="{{ url('search') }}" method="GET">
            <button type="submit">
                <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img"
                    aria-labelledby="search">
                    <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9"
                        stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </button>

            <input class="input" placeholder="ابحث عن فعالية..." required="" type="text" name="search"
                value="{{ request('search') }}">

            <button class="reset" type="reset">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </form>
        {{-- @endif --}}

        <!-- بطاقات الإحصائيات -->
        <div class="main-dashboard-header-right d-flex gap-4 justify-content-end text-end hide-on-small">

            <div>
                <label class="tx-13 mb-1 d-block"><strong>الفعاليات القادمة</strong></label>
                <div class="main-star">
                    <h5 class="mb-0 text-primar y">{{ $upcomingEventsCount }}</h5>
                </div>
            </div>

            <div>
                <label class="tx-13 mb-1 d-block"><strong>التصنيفات</strong></label>
                <h5 class="mb-0 text-info">{{ $categories_count }}</h5>
            </div>
            @can('التقارير')
                <div>
                    <label class="tx-13 mb-1 d-block"><strong>كل الحجوزات</strong></label>
                    <h5 class="mb-0 text-success">{{ $BookingsCount }}</h5>
                </div>
            @endcan
            @can('المستخدمين')
                @if (Auth::user()->is_admin == 0 ?? '')
                    <div>
                        <label class="tx-13 mb-1 d-block"><strong>حجوزاتك اليوم</strong></label>
                        <h5 class="mb-0 text-success">{{ $bookings }}</h5>
                    </div>
                @endif
            @endcan
        </div>
        <div class="main-header-right">
            <div class="nav navbar-nav-right ml-auto d-flex align-items-center gap-4">
                <!-- زر الشاشة الكاملة -->
                <div class="nav-item fullscreen-button">
                    <a class="nav-link full-screen-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                            </path>
                        </svg>
                    </a>
                </div>

                <!-- صورة المستخدم -->
                <div class="dropdown main-profile-menu nav-link">
                    <a class="profile-user d-flex" href="#">
                        <img alt="user" src="{{ asset('assets/img/faces/circle-user-solid.svg') }}">
                    </a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex">
                                <div class="main-img-user">
                                    <img src="{{ asset('assets/img/faces/circle-user-solid.svg') }}" alt="">
                                </div>
                                <div class="mr-3 my-auto">
                                    <h6>{{ Auth::user()->name ?? 'Gust' }}</h6>
                                    <span>{{ Auth::user()->email ?? '' }}</span>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="bx bx-log-out"></i> تسجيل خروج
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>

                <!-- الإشعارات -->
                @can('الاشعارات')
                    <div class="dropdown main-header-message right-toggle">
                        <a class="nav-link pr-0" data-toggle="sidebar-left" data-target=".sidebar-left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                            <span class="pulse notification-badge" id="unreadCount"
                                style="display: {{ \Illuminate\Notifications\DatabaseNotification::whereNull('read_at')->exists() ? 'block' : 'none' }}"></span>
                        </a>
                    </div>
                @endcan
            </div>
        </div>

    </div>
</div>
<!-- /main-header -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/main-header.js') }}"></script>
<script>
    setInterval(function() {
        $.get(window.location.href, function(data) {
            var newDoc = $(data);
            var unreadCount = newDoc.find('#unreadCount').text(); // احصل على العدد

            if (unreadCount > 0) {
                $('#unreadCount').show().text(unreadCount);
            } else {
                $('#unreadCount').hide();
            }
        });
    }, 5000);
</script>
