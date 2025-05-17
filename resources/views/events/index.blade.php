@extends('layouts.master')
@section('title', 'الفعاليات')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/events/events.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <h4 class="content-title mb-0 my-auto">إدارة الفعاليات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفعاليات</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">جميع الفعاليات</h4>
                        <a href="{{ route('events.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> إضافة فعالية
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="events-table" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم الفعالية</th>
                                    <th>الصورة</th>
                                    <th>التصنيف</th>
                                    <th>التاريخ</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $event->title }}</td>
                                        <td>
                                            @if ($event->image)
                                                {{-- <img src="{{ asset('storage/'.$event->image) }}" width="50" class="img-thumbnail"> --}}
                                                <img src="{{ $event->image ?? asset('images/default-event.jpg') }}"
                                                    class="event-img img-thumbnail"
                                                    style="width: 70px; height: 70px; object-fit: cover;"
                                                    alt="{{ $event->title }}">
                                            @else
                                                <span class="text-muted">بدون صورة</span>
                                            @endif
                                        </td>
                                        <td>{{ $event->category->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</td>
                                        <td>
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
                                        </td>
                                        <td>
                                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('events.edit', $event->id) }}"
                                                class="btn btn-sm btn-primary">
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
            $('#events-table').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
                }
            });
        });
    </script>
@endsection
