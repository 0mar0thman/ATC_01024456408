@extends('layouts.master')
@section('title', 'نتائج البحث')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/user/home.css') }}">
@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-3">
                <!-- تصفية البحث -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5>تصفية النتائج</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('search') }}" method="GET">
                            <div class="mb-3">
                                <label for="search" class="form-label">كلمة البحث</label>
                                <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">التصنيف</label>
                                <select name="category" class="form-select">
                                    <option value="">جميع التصنيفات</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">التاريخ</label>
                                <select name="date" class="form-select">
                                    <option value="">أي تاريخ</option>
                                    <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>اليوم</option>
                                    <option value="week" {{ request('date') == 'week' ? 'selected' : '' }}>هذا الأسبوع
                                    </option>
                                    <option value="month" {{ request('date') == 'month' ? 'selected' : '' }}>هذا الشهر
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">السعر</label>
                                <select name="price" class="form-select">
                                    <option value="">الكل</option>
                                    <option value="free" {{ request('price') == 'free' ? 'selected' : '' }}>مجاني</option>
                                    <option value="paid" {{ request('price') == 'paid' ? 'selected' : '' }}>مدفوع
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="sort" class="form-label">ترتيب حسب</label>
                                <select name="sort" class="form-select">
                                    <option value="">الأحدث</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>الأكثر
                                        شعبية</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">تطبيق الفلتر</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>نتائج البحث</h2>
                    <div class="text-muted">
                        {{ $events->total() }} نتيجة وجدت
                    </div>
                </div>

                @if ($events->isEmpty())
                    <div class="alert alert-info">
                        <h5>لا توجد نتائج مطابقة لبحثك</h5>
                        <p>حاول تعديل معايير البحث أو <a href="{{ route('home') }}">العودة للصفحة الرئيسية</a></p>
                    </div>
                @else
                    <div class="row">
                        @foreach ($events as $event)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100">
                                    {{-- <img src="{{ $event->image ? asset('Attachments/Events/' . $event->image) : asset('images/default-event.jpg') }}"
                                        class="card-img-top" alt="{{ $event->title }}"> --}}
                                    <img src="{{ $event->image ?? asset('images/default-event.jpg') }}" class="event-img"
                                        alt="{{ $event->title }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $event->title }}</h5>
                                        <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-primary">{{ $event->category->name }}</span>
                                            <span class="text-muted">{{ $event->date->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white">
                                        <a href="{{ route('events.show', $event->id) }}"
                                            class="btn btn-sm btn-outline-primary">التفاصيل</a>
                                        <a href="{{ route('user.bookings.create', $event->id) }}"
                                            class="btn btn-sm btn-primary float-left">احجز الآن</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $events->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
