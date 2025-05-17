@extends('layouts.master')
@section('title', $event->title)
<link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفعاليات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $event->title }}</span>
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
                        <h4 class="card-title">تفاصيل الفعالية</h4>
                        <span
                            class="badge
                        @if ($event->date > now()) badge-success
                        @else badge-secondary @endif">
                            @if ($event->date > now())
                                قادمة
                            @else
                                منتهية
                            @endif
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if ($event->image)
                                {{-- <img src="{{ $event->image ? asset('Attachments/Events/' . $event->image) : asset('images/default-event.jpg') }}"
                                    class="event-img" alt="{{ $event->name }}"> --}}
                                <img src="{{ $event->image ?? asset('images/default-event.jpg') }}" class="event-img"
                                    alt="{{ $event->title }}">
                            @else
                                <div class="no-image-placeholder text-center py-5 bg-light">
                                    <i class="fas fa-calendar-alt fa-5x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3>{{ $event->title }}</h3>
                            <p class="text-muted">{{ $event->category->name }}</p>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>التاريخ:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                                    </p>
                                    <p><strong>المكان:</strong> {{ $event->venue }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>السعر:</strong> {{ $event->price }} ر.س</p>
                                    <p><strong>السعة:</strong> {{ $event->capacity }} أشخاص</p>
                                </div>
                            </div>
                            <hr>
                            <h5>الوصف:</h5>
                            <p>{{ $event->description ?? 'لا يوجد وصف' }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        @can('الاعدادات')
                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> تعديل
                            </a>
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
