@extends('layouts.master')

@section('title', 'منصة حجز الفعاليات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/user/home.css') }}">
    <!-- تأكد من الرابط بهذا الشكل -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* From Uiverse.io by LightAndy1 */
        .group2 {
            display: flex;
            line-height: 28px;
            align-items: center;
            position: relative;
            max-width: 100%;
        }

        .input2 {
            width: 100%;
            height: 40px;
            line-height: 28px;
            padding: 0 1rem;
            padding-left: 2.5rem;
            border: 2px solid transparent;
            border-radius: 8px;
            outline: none;
            background-color: #f3f3f4;
            color: #0d0c22;
            transition: 0.3s ease;
        }

        .input2::placeholder {
            color: #9e9ea7;
        }

        .input2:focus,
        .input2:hover {
            outline: none;
            border-color: rgba(0, 48, 73, 0.4);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgb(0 48 73 / 10%);
        }

        .icon2 {
            position: absolute;
            left: 1rem;
            fill: #9e9ea7;
            width: 1rem;
            height: 1rem;
        }

        .form-select {
            padding: 20px;
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    {{-- style="background-color: rgba(162, 162, 162, 0.25); border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);" --}}
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-6 ">
                    <h1 class="fw-bold mb-3 text-white">اكتشف أفضل الفعاليات حولك</h1>
                    <p class="lead text-white-50">احجز مقعدك في أحدث الفعاليات والحفلات وورش العمل والمؤتمرات بكل سهولة
                        وأمان</p>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('assets/img/Booking.svg') }}" alt="Hero Illustration" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="bg-light mt-4">
        <div class="container">
            <h2 class="section-title mb-3">كيفية الحجز في 3 خطوات بسيطة</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <i class="fas fa-search fa-5x"></i>
                        <h4 class="mb-3 mt-3">ابحث عن الفعالية</h4>
                        <p class="mb-0">تصفح بين مئات الفعاليات المختلفة واختر ما يناسبك</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <i class="fas fa-ticket-alt fa-5x"></i>
                        <h4 class="mb-3 mt-3">احجز تذكرتك</h4>
                        <p class="mb-0">اختر عدد التذاكر وأكمل عملية الدفع بسهولة</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <i class="fas fa-calendar-check fa-5x"></i>
                        <h4 class="mb-3 mt-3">استمتع بالفعالية</h4>
                        <p class="mb-0">احصل على التذكرة على بريدك واستمتع بالفعالية</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Events Slider -->
    <section class="mt-4">
        <div class="container">
            <h2 class="section-title mb-3">فعاليات مميزة</h2>
            <div class="row">
                @foreach ($featuredEvents as $event)
                    <div class="col-md-6 mb-4">
                        <div class="event-card h-100">
                            <div class="event-img-container">
                                {{-- <img src="{{ $event->image ? asset('Attachments/Events/' . $event->image) : asset('images/default-event.jpg') }}"
                                    class="event-img" alt="{{ $event->name }}"> --}}
                                <img src="{{ $event->image ?? asset('images/default-event.jpg') }}" class="event-img"
                                    alt="{{ $event->title }}">
                                @if ($event->is_featured)
                                    <div class="event-featured-badge event-badge">
                                        مميز
                                    </div>
                                @endif
                                <div class="event-date-badge event-badge">
                                    {{ $event->date->format('d M') }}
                                </div>
                                <div class="event-category-badge event-badge">
                                    {{ $event->category->name }}
                                </div>
                            </div>
                            <div class="card-body">
                                <h3 class="event-title">{{ $event->title }}</h3>
                                <div class="event-meta">
                                    <span class="event-meta-item">
                                        <i class="fas fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                                    </span>
                                    <span class="event-meta-item">
                                        <i class="fas fa-map-marker-alt"></i> {{ $event->venue }}
                                    </span>
                                    <span class="event-meta-item">
                                        <i class="fas fa-users"></i> {{ $event->capacity }} مقاعد متبقية
                                    </span>
                                </div>
                                <p class="event-description">{{ Str::limit($event->description, 120) }}</p>
                                <div class="event-footer">
                                    <span class="event-price">
                                        @if ($event->price > 0)
                                            {{ number_format($event->price) }} ج.م
                                        @else
                                            مجاني
                                        @endif
                                    </span>
                                    <div class="event-actions">
                                        <a href="{{ route('events.show', $event->id) }}"
                                            class="btn btn-sm btn-outline-primary">التفاصيل</a>
                                        @if ($event->capacity > 0)
                                            <a href="{{ route('user.bookings.create', $event->id) }}"
                                                class="btn btn-sm btn-primary">احجز الآن</a>
                                        @else
                                            <p class="btn btn-sm btn-warning">السعة ممتلئة</p>
                                        @endif
                                        @can('الاعدادات')
                                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                                style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('هل أنت متأكد؟')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Events Search -->
    <section id="events">
        <div class="container">
            <h2 class="section-title mb-3 mt-2">ابحث عن فعاليتك</h2>
            <div class="search-filter-section">
                <form action="{{ url('search') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="category" id="category" class="form-select"
                                    aria-label="Default select example">
                                    <option value="">جميع التصنيفات</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->id }} - {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="date" name="date" id="date" class="form-control"
                                    value="{{ request('date') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="price" id="price" class="form-select"
                                    aria-label="Default select example">
                                    <option value="">جميع الفعاليات</option>
                                    <option value="free" {{ request('price') == 'free' ? 'selected' : '' }}>فعاليات
                                        مجانية</option>
                                    <option value="paid" {{ request('price') == 'paid' ? 'selected' : '' }}>فعاليات
                                        مدفوعة</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <div class="form-floating">
                                <div class="group2 ">
                                    <svg viewBox="0 0 24 24" aria-hidden="true" class="icon2 ">
                                        <g>
                                            <path
                                                d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                                            </path>
                                        </g>
                                    </svg>
                                    <input class="input2" type="search" placeholder="ابحث عن فعالية..." />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-2">
                            <button type="submit" class="btn btn-primary w-100">بحث</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class=" ">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title mb-3">الفعاليات القادمة والمتاحة</h2>
                    <div class="d-flex gap-2">
                        <a href="{{ url('/user/home?sort=date') }}"
                            class="btn btn-sm btn-outline-primary {{ request('sort') == 'date' ? 'active' : '' }}">
                            حسب التاريخ
                        </a>
                        <a href="{{ url('/user/home?sort=popular') }}"
                            class="btn btn-sm btn-outline-primary {{ request('sort') == 'popular' ? 'active' : '' }}">
                            الأكثر شعبية
                        </a>
                    </div>
                </div>

                @if ($events->isEmpty())
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <img src="{{ $event->image ? asset('Attachments/Events/' . $event->image) : asset('images/default-event.jpg') }}"
                                style="max-height: 200px;">
                            <h4>لا توجد فعاليات متاحة حالياً</h4>
                            <p class="text-muted">يمكنك متابعتنا لمعرفة الفعاليات القادمة أو تعديل معايير البحث</p>
                            <a href="{{ route('events.index') }}" class="btn btn-primary mt-3">عرض جميع الفعاليات</a>
                        </div>
                    </div>
                @else
                    <div class="row g-4 bg-white">
                        @foreach ($events as $event)
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="event-card h-100 ">
                                    <div class="event-img-container">
                                        {{-- <img src="{{ $event->image ? asset('Attachments/Events/' . $event->image) : asset('images/default-event.jpg') }}"
                                            class="event-img" alt="{{ $event->title }}"> --}}
                                        <img src="{{ $event->image ?? asset('images/default-event.jpg') }}"
                                            class="event-img" alt="{{ $event->title }}">

                                        <div class="event-date-badge event-badge">
                                            {{ $event->date->format('d M') }}
                                        </div>
                                        <div class="event-category-badge event-badge">
                                            {{ $event->category->name }}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="event-title">{{ $event->title }}</h3>
                                        <div class="event-meta">
                                            <span class="event-meta-item">
                                                <i class="fas fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                                            </span>
                                            <span class="event-meta-item">
                                                <i class="fas fa-map-marker-alt"></i> {{ $event->venue }}
                                            </span>
                                            <span class="event-meta-item">
                                                <i class="fas fa-users"></i> {{ $event->capacity }} مقاعد متبقية
                                            </span>
                                        </div>
                                        <p class="event-description">{{ Str::limit($event->description, 100) }}</p>
                                        <div class="event-footer">
                                            <span class="event-price">
                                                @if ($event->price > 0)
                                                    {{ number_format($event->price) }} ج.م
                                                @else
                                                    مجاني
                                                @endif
                                            </span>
                                            <div class="event-actions">
                                                <a href="{{ route('events.show', $event->id) }}"
                                                    class="btn btn-sm btn-outline-primary">التفاصيل</a>
                                                @if ($event->capacity > 0)
                                                    <a href="{{ route('user.bookings.create', $event->id) }}"
                                                        class="btn btn-sm btn-primary">احجز الآن</a>
                                                @else
                                                    <p class="btn btn-sm btn-warning">السعة ممتلئة</p>
                                                @endif
                                                @can('الاعدادات')
                                                    <a href="{{ route('events.edit', $event->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                                        style="display:inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('هل أنت متأكد؟')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($events->hasPages())
                        <section class="py-2">
                            <div class="container">
                                <div class="row g-4 justify-content-center">
                                    <div class="col-12">
                                        <div class="pagination-container text-center">
                                            {{ $events->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif
                @endif
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="rounded">
        <div class="container">
            <h2 class="section-title mb-5">تصنيفات الفعاليات</h2>
            <div class="row g-4 bg-white rounded">
                @foreach ($categories as $category)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-2">
                        <a href="{{ url('search?category=' . $category->id) }}"
                            class="category-card text-left p-4 d-block bg-secondary text-white rounded shadow-sm h-100">
                            <div class="icon mb-3 text-warning">
                                <p>{{ $category->slug }}</p>
                            </div>
                            <h5 class="mb-1">{{ $category->name }}</h5>
                            <p class="small mb-0">{{ $category->events_count }} فعالية</p>
                        </a>
                    </div>
                @endforeach
            </div>
            {{-- Pagination for Categories      shadow-sm --}}
            @if ($categories->hasPages())
                <section class="py-2">
                    <div class="container">
                        <div class="row g-4 justify-content-center">
                            <div class="col-12">
                                <div class="pagination-container rounded text-center">
                                    {{ $events->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="bg-light">
        <div class="container mb-3">
            <h2 class="section-title mb-3">آراء عملائنا</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/img/avatar1.jpg') }}" alt="User" class="rounded-circle me-3"
                                width="60">
                            <div class="mr-2">
                                <h5 class="mb-0">أحمد محمد</h5>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mb-0">"منصة رائعة وسهلة الاستخدام، حجزت تذكرتي لحفل موسيقي في دقائق معدودة!"</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/img/avatar2.jpg') }}" alt="User" class="rounded-circle me-3"
                                width="60">
                            <div class="mr-2">
                                <h5 class="mb-0">سارة عبدالله</h5>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mb-0">"أعجبني تنوع الفعاليات وسرعة تأكيد الحجز، شكراً لكم على هذه الخدمة المميزة"</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/img/avatar3.avif') }}" alt="User" class="rounded-circle me-3"
                                width="60">
                            <div class="mr-2">
                                <h5 class="mb-0">خالد سعيد</h5>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mb-0">"تجربة ممتازة، استطعت حجز تذاكر لجميع أفراد العائلة بسهولة وسرعة"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    <!-- Owl Carousel -->
    <script src="{{ asset('assets/plugins/owl-carousel/owl.carousel.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize Owl Carousel for featured events
            $('.owl-carousel').owlCarousel({
                rtl: true,
                loop: true,
                margin: 20,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    }
                }
            });

            // Smooth scroll for anchor links
            $('a[href^="#"]').on('click', function(event) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: $($(this).attr('href')).offset().top - 80
                }, 800);
            });

            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
