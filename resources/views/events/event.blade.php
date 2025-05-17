@extends('layouts.master')
@section('title')
    الفعاليات
@stop

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!-- Custom CSS for events -->
    <link href="{{ URL::asset('assets/css/events/events.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <h4 class="content-title mb-0 my-auto">إدارة الفعاليات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفعاليات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>قائمة الفعاليات</h5>
                        @can('اضافة فعالية')
                            <a class="btn btn-outline-info" data-effect="effect-scale" data-toggle="modal"
                                href="#addEventModal">
                                <i class="fas fa-plus ml-1"></i> إضافة فعالية
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="eventsTable" class="table table-hover text-md-nowrap">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>اسم الفعالية</th>
                                    <th>الصورة</th>
                                    <th>التصنيف</th>
                                    <th>التاريخ</th>
                                    <th>المكان</th>
                                    <th>السعر</th>
                                    <th>السعة</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($events as $event)
                                    <tr>
                                        <td>{{ $event->id }}</td>
                                        <td>{{ $event->title }}</td>
                                        <td>
                                            @if ($event->image)
                                                {{-- <img src="{{ asset('storage/' . $event->image) }}" width="50"
                                                    height="50" class="img-thumbnail"> --}}
                                                <img src="{{ $event->image ?? asset('images/default-event.jpg') }}"
                                                    class="event-img" alt="{{ $event->title }}">
                                            @else
                                                <span class="text-muted">بدون صورة</span>
                                            @endif
                                        </td>
                                        <td>{{ $event->category->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</td>
                                        <td>{{ $event->venue }}</td>
                                        <td>{{ $event->price }} ر.س</td>
                                        <td>{{ $event->capacity }}</td>
                                        <td>
                                            {{-- @can('تعديل فعالية') --}}
                                            <a href="{{ route('events.edit', $event->id) }}"
                                                class="btn btn-outline-success btn-sm">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>
                                            {{-- @endcan --}}
                                            {{-- @can('حذف فعالية') --}}
                                            <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('هل أنت متأكد من حذف هذه الفعالية؟')">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            </form>
                                            {{-- @endcan --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Event Modal -->
        <div class="modal fade" id="addEventModal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">إضافة فعالية جديدة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('events.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>اسم الفعالية</label>
                                        <input type="text" class="form-control" name="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label>التصنيف</label>
                                        <select name="category_id" class="form-control" required>
                                            <option value="" selected disabled>-- اختر التصنيف --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>تاريخ الفعالية</label>
                                        <input type="date" class="form-control" name="date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>مكان الفعالية</label>
                                        <input type="text" class="form-control" name="venue" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>السعر (ر.س)</label>
                                        <input type="number" class="form-control" name="price" min="0" required>
                                    </div>
                                    <div class="form-group">
                                        <label>السعة (عدد الأشخاص)</label>
                                        <input type="number" class="form-control" name="capacity" min="1" required>
                                    </div>
                                    <div class="form-group">
                                        <label>صورة الفعالية</label>
                                        <input type="file" class="form-control" name="image" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>وصف الفعالية</label>
                                <textarea class="form-control" name="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">حفظ</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Include all DataTables scripts -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with Arabic language
            $('#eventsTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                },
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        text: 'تصدير Excel',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'print',
                        text: 'طباعة',
                        className: 'btn btn-secondary'
                    }
                ],
                responsive: true
            });
        });
    </script>
@endsection
