@extends('layouts.master')
@section('title', 'تفاصيل الحجز #' . $booking->id)
 <link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الحجوزات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الحجز #{{ $booking->id }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">تفاصيل الحجز</h4>
                        <div>
                            <span
                                class="badge
                                @if ($booking->status == 'confirmed') badge-success
                                @elseif($booking->status == 'cancelled') badge-danger
                                @else badge-info @endif">
                                {{ $booking->status }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>معلومات الفعالية</h5>
                            <hr>
                            <p><strong>اسم الفعالية:</strong> {{ $booking->event->title }}</p>
                            <p><strong>التاريخ:</strong> {{ $booking->event->date->format('Y-m-d') }}</p>
                            <p><strong>المكان:</strong> {{ $booking->event->venue }}</p>
                            <p><strong>السعر للفرد:</strong> {{ $booking->event->price }} ج.م</p>
                        </div>
                        <div class="col-md-6">
                            <h5>معلومات الحجز</h5>
                            <hr>
                            <p><strong>رقم الحجز:</strong> #{{ $booking->id }}</p>
                            <p><strong>المستخدم:</strong> {{ $booking->user->name }}</p>
                            <p><strong>عدد التذاكر:</strong> {{ $booking->tickets }}</p>
                            <p><strong>المبلغ الإجمالي:</strong> {{ $booking->tickets * $booking->event->price }} ج.م</p>
                            <p><strong>تاريخ الحجز:</strong> {{ $booking->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                        <div class="col-md-12 mt-4">
                            <h5>ملاحظات</h5>
                            <hr>
                            <p>{{ $booking->notes ?? 'لا توجد ملاحظات' }}</p>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        @can('التقارير')
                            <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> تعديل
                            </a>
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </form>
                        @endcan
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> رجوع
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
