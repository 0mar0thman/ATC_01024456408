@extends('layouts.master')
@section('title', 'حجز فعالية')
 <link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الحجوزات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ حجز فعالية: {{ $event->title }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">حجز فعالية: {{ $event->title }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>التاريخ:</strong> {{ $event->date->format('Y-m-d') }}</p>
                            <p><strong>المكان:</strong> {{ $event->venue }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>السعر:</strong> {{ $event->price }} ج.م</p>
                            <p><strong>المقاعد المتاحة:</strong> {{ $event->available_seats }}</p>
                        </div>
                    </div>

                    <form action="{{ route('bookings.store.event', $event->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>المستخدم</label>
                                    <select name="user_id" class="form-control" required>
                                        <option value="">اختر مستخدم</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>عدد التذاكر</label>
                                    <input type="number" name="tickets" class="form-control"
                                           min="1" max="{{ $event->available_seats }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>ملاحظات</label>
                                    <textarea name="notes" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">تأكيد الحجز</button>
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
