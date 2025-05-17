<!-- الاعدادات -->
@can('الاعدادات')
    @extends('layouts.master')
    @section('title')
        الرئيسية
    @stop

    @section('css')
        <!--  Owl-carousel css-->
        <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
        <!-- Maps css -->
        <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
    @endsection
    @section('page-header')
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <div>
                    <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1"><strong>مرحبًا بك في نظام حجز الفعاليات</strong></h2>
                    <p class="mg-b-0 mt-3">نظام إدارة الفعاليات والحجوزات</p>
                </div>
            </div>
            <div class="main-dashboard-header-right">
                <div>
                    <label class="tx-13 mb-2"><strong>إجمالي الفعاليات</strong></label>
                    <div class="main-star">
                        <h5>{{ $stats['total_events'] ?? 0 }}</h5>
                    </div>
                </div>
                <div>
                    <label class="tx-13 mb-2"><strong>الحجوزات النشطة</strong></label>
                    <h5>{{ $stats['active_bookings'] ?? 0 }}</h5>
                </div>
                <div>
                    <label class="tx-13 mb-2"><strong>المستخدمون المسجلون</strong></label>
                    <h5>{{ $stats['total_users'] ?? 0 }}</h5>
                </div>
            </div>
        </div>
        <!-- /breadcrumb -->
    @endsection
    @section('content')
        <!-- row -->
        <div class="row row-sm">
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h5 class="mb-3 tx-15 text-white"><strong>إجمالي الفعاليات</strong></h5>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-24 font-weight-bold mb-1 text-white">
                                        {{ $stats['total_events'] ?? 0 }}
                                    </h4>
                                    <p class="mb-0 tx-12 text-white op-7">جميع الفعاليات في النظام</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-15 text-white"><strong>الفعاليات القادمة</strong></h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div>
                                    <h4 class="tx-24 font-weight-bold mb-1 text-white">
                                        {{ $stats['upcoming_events'] ?? 0 }}
                                    </h4>
                                    <p class="mb-0 tx-12 text-white op-7">فعاليات لم تقم بعد</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-success-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-15 text-white"><strong>الحجوزات اليوم</strong></h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div>
                                    <h4 class="tx-24 font-weight-bold mb-1 text-white">
                                        {{ $stats['today_bookings'] ?? 0 }}
                                    </h4>
                                    <p class="mb-0 tx-12 text-white op-7">حجوزات تمت اليوم</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-warning-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-15 text-white"><strong>أعلى فعالية</strong></h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div>
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                        {{ $stats['top_event'] ?? 'N/A' }}
                                    </h4>
                                    <p class="mb-0 tx-12 text-white op-7">بـ {{ $stats['top_event_bookings'] ?? 0 }} حجز</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->

        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-md-12 col-lg-12 col-xl-7">
                <div class="card">
                    <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0 col-xl-5">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mb-0">توزيع الفعاليات حسب الفئة</h4>
                        </div>
                        <p class="tx-12 text-muted mt-2">إحصائيات تفصيلية عن الفعاليات حسب التصنيف</p>
                    </div>
                    <div class="col-xl-12 col-md-12 col-lg-6 mt-2">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>
                                        <div style="width: 100%; max-width: 600px;">
                                            {!! $eventsChart->render() !!}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-xl-5">
                <div class="card card-dashboard-map-one">
                    <label class="main-content-label">الفعاليات القادمة</label>
                    <span class="d-block mg-b-20 text-muted tx-12">أهم 5 فعاليات قادمة في الأيام المقبلة</span>
                    <div class="vmap-wrapper ht-180">
                        @foreach ($upcomingEvents as $event)
                            <div class="event-item">
                                <span class="event-name">{{ $event->name }}</span>
                                <span class="event-date">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</span>
                                <span class="event-venue">{{ $event->venue }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->

        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-4 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header pb-1">
                        <h3 class="card-title mb-2">أكثر المستخدمين نشاطاً</h3>
                        <p class="tx-12 mb-0 text-muted">أعلى 5 مستخدمين حسب عدد الحجوزات</p>
                    </div>
                    <div class="card-body p-0 customers mt-1">
                        <div class="list-group list-lg-group list-group-flush">
                            @foreach ($activeUsers as $user)
                                <div class="list-group-item list-group-item-action">
                                    <div class="media mt-0">
                                        <div
                                            class="avatar-lg rounded-circle bg-primary text-white d-flex align-items-center justify-content-center">
                                            {{ substr($user['name'], 0, 1) }}

                                        </div>
                                        <div class="media-body mr-2">
                                            <div class="d-flex align-items-center">
                                                <div class="mt-0">
                                                    <h5 class="mb-1 tx-15">{{ $user['name'] }}</h5>
                                                    <p class="mb-0 tx-13 text-muted">حجوزات: {{ $user['bookings_count'] }}</p>
                                                    <p class="mb-0 tx-12 text-muted">آخر حجز: {{ $user['last_booking_date'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header pb-1">
                        <h3 class="card-title mb-2">أحدث الحجوزات</h3>
                        <p class="tx-12 mb-0 text-muted">آخر 5 حجوزات تمت في النظام</p>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($recentBookings as $booking)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="tx-medium">#{{ $booking->id }}</span>
                                        <span class="tx-12 d-block">{{ $booking->event?->title ?? 'لا يوجد عنوان' }}</span>
                                    </div>
                                    <span class="badge badge-primary">{{ $booking->created_at->format('d/m/Y') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3 class="card-title mb-2">الفعاليات الأكثر شعبية</h3>
                        <p class="tx-12 mb-3 text-muted">أعلى 5 فعاليات حسب عدد الحجوزات</p>
                    </div>
                    <div class="card-body sales-info ot-0 pt-0 pb-2">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-25p">اسم الفعالية</th>
                                        <th class="wd-35p">التاريخ</th>
                                        <th class="wd-25p tx-right">عدد الحجوزات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($popularEvents as $event)
                                        <tr>
                                            <td class="tx-medium">{{ $event['title'] }}</td>
                                            <td class="tx-12">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                                            <td class="text-right">{{ $event['bookings_count'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row close -->
    @endsection
    @section('js')
        <!--Internal  Chart.bundle js -->
        <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
        <!-- Moment js -->
        <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
        <!--Internal  Flot js-->
        <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
        <script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
        <script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
        <!--Internal Apexchart js-->
        <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
        <!-- Internal Map -->
        <script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
        <script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
        <!--Internal  index js -->
        <script src="{{ URL::asset('assets/js/index.js') }}"></script>
        <script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
    @endsection
@endcan
