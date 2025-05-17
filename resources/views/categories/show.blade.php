@extends('layouts.master')
@section('title', $category->name)
 <link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">التصنيفات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $category->name }}</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">تفاصيل التصنيف</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>معلومات أساسية</h5>
                        <hr>
                        <p><strong>اسم التصنيف:</strong> {{ $category->name }}</p>
                        {{-- <p><strong>الرابط:</strong> {{ $category->slug }}</p> --}}
                        <p><strong>عدد الفعاليات:</strong> {{ $category->events_count }}</p>
                        <p><strong>تاريخ الإنشاء:</strong> {{ $category->created_at->format('Y-m-d') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>الوصف</h5>
                        <hr>
                        <p>{{ $category->description ?? 'لا يوجد وصف' }}</p>
                    </div>
                </div>

                @if($category->events_count > 0)
                <div class="mt-4">
                    <h5>الفعاليات في هذا التصنيف</h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>اسم الفعالية</th>
                                    <th>التاريخ</th>
                                    <th>المكان</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category->events as $event)
                                <tr>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->date->format('Y-m-d') }}</td>
                                    <td>{{ $event->venue }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> تعديل
                    </a>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> رجوع
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
