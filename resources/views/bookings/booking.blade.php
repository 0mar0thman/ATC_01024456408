@extends('layouts.master')
@section('title', 'إدارة الحجوزات')

@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الحجوزات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الحجوزات</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">جميع الحجوزات</h4>
                        <a href="{{ route('events.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> حجز جديد
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="bookings-table" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الفعالية</th>
                                    <th>المستخدم</th>
                                    <th>عدد التذاكر</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الحجز</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->event->title ?? 'غير موجود' }}</td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ $booking->tickets }}</td>
                                    <td>
                                        <span class="badge
                                            @if($booking->status == 'confirmed') badge-success
                                            @elseif($booking->status == 'cancelled') badge-danger
                                            @else badge-info @endif">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                    <td>{{ $booking->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#bookings-table').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
                }
            });
        });
    </script>
@endsection
