@extends('layouts.master')
@section('title', 'تعديل الحجز')
 <link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الحجوزات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل الحجز #{{ $booking->id }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">تعديل الحجز</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الفعالية</label>
                                    <select name="event_id" class="form-control" required>
                                        @foreach($events as $event)
                                            <option value="{{ $event->id }}"
                                                {{ $booking->event_id == $event->id ? 'selected' : '' }}
                                                data-available="{{ $event->available_seats + $booking->tickets }}">
                                                {{ $event->title }} ({{ $event->date->format('Y-m-d') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">المقاعد المتاحة: <span id="available-seats">0</span></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>المستخدم</label>
                                    <select name="user_id" class="form-control" required>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ $booking->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>عدد التذاكر</label>
                                    <input type="number" name="tickets" class="form-control"
                                           value="{{ $booking->tickets }}" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>حالة الحجز</label>
                                    <select name="status" class="form-control" required>
                                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>ملاحظات</label>
                                    <textarea name="notes" class="form-control" rows="2">{{ $booking->notes }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // تحديث عدد المقاعد المتاحة عند تغيير الفعالية
            $('select[name="event_id"]').change(function() {
                const available = $(this).find(':selected').data('available');
                $('#available-seats').text(available);
                $('input[name="tickets"]').attr('max', available);
            }).trigger('change');
        });
    </script>
@endsection
