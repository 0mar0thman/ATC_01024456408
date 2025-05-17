@extends('layouts.master')
@section('title', 'إنشاء حجز جديد')
 <link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الحجوزات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إنشاء حجز جديد</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">إضافة حجز جديد</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الفعالية</label>
                                    <select name="event_id" class="form-control" required>
                                        <option value="">اختر فعالية</option>
                                        @foreach($events as $event)
                                            <option value="{{ $event->id }}"
                                                data-available="{{ $event->available_seats }}">
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
                                        <option value="">اختر مستخدم</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>عدد التذاكر</label>
                                    <input type="number" name="tickets" class="form-control" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ملاحظات</label>
                                    <textarea name="notes" class="form-control" rows="1"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">حفظ الحجز</button>
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
            $('select[name="event_id"]').change(function() {
                const available = $(this).find(':selected').data('available');
                $('#available-seats').text(available);
                $('input[name="tickets"]').attr('max', available);
            });
        });
    </script>
@endsection
