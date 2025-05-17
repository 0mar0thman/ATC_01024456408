@extends('layouts.master')
@section('title')
    التصنيفات
@stop

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!-- Custom CSS for categories -->
    <link href="{{ URL::asset('assets/css/categories/categories.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <h4 class="content-title mb-0 my-auto">إدارة التصنيفات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة التصنيفات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    @include('partials.alerts')

    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>قائمة التصنيفات</h5>
                        @can('اضافة تصنيف')
                            <a class="btn btn-outline-info" data-effect="effect-scale" data-toggle="modal" href="#addCategoryModal">
                                <i class="fas fa-plus ml-1"></i> إضافة تصنيف
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="categoriesTable" class="table table-hover text-md-nowrap">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>اسم التصنيف</th>
                                    {{-- <th>الرابط</th> --}}
                                    <th>عدد الفعاليات</th>
                                    <th>تاريخ الإضافة</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        {{-- <td>{{ $category->slug }}</td> --}}
                                        <td>{{ $category->events_count }}</td>
                                        <td>{{ $category->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            @can('تعديل تصنيف')
                                                <button class="btn btn-outline-success btn-sm edit-category"
                                                    data-id="{{ $category->id }}"
                                                    data-name="{{ $category->name }}"
                                                    data-slug="{{ $category->slug }}"
                                                    data-description="{{ $category->description }}"
                                                    data-toggle="modal"
                                                    data-target="#editCategoryModal">
                                                    <i class="fas fa-edit"></i> تعديل
                                                </button>
                                            @endcan
                                            @can('حذف تصنيف')
                                                <button class="btn btn-outline-danger btn-sm delete-category"
                                                    data-id="{{ $category->id }}"
                                                    data-name="{{ $category->name }}"
                                                    data-toggle="modal"
                                                    data-target="#deleteCategoryModal">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Category Modal -->
        <div class="modal fade" id="addCategoryModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">إضافة تصنيف جديد</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('categories.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>اسم التصنيف</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>الرابط (Slug)</label>
                                <input type="text" class="form-control" name="slug" required>
                                <small class="text-muted">يستخدم في روابط الموقع (يجب أن يكون فريدًا)</small>
                            </div>
                            <div class="form-group">
                                <label>الوصف</label>
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

        <!-- Edit Category Modal -->
        <div class="modal fade" id="editCategoryModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل التصنيف</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('categories.update') }}" method="post">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="id" id="editCategoryId">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>اسم التصنيف</label>
                                <input type="text" class="form-control" name="name" id="editCategoryName" required>
                            </div>
                            <div class="form-group">
                                <label>الرابط (Slug)</label>
                                <input type="text" class="form-control" name="slug" id="editCategorySlug" required>
                            </div>
                            <div class="form-group">
                                <label>الوصف</label>
                                <textarea class="form-control" name="description" id="editCategoryDescription" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">تحديث</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Category Modal -->
        <div class="modal fade" id="deleteCategoryModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">حذف التصنيف</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('categories.destroy') }}" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="id" id="deleteCategoryId">
                        <div class="modal-body">
                            <p>هل أنت متأكد من حذف التصنيف "<span id="deleteCategoryName"></span>"؟</p>
                            <p class="text-danger">تحذير: سيتم إزالة هذا التصنيف من جميع الفعاليات المرتبطة به!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-danger">تأكيد الحذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Include DataTables scripts as before -->

    <script>
        $(document).ready(function() {
            // Initialize DataTable with Arabic language
            $('#categoriesTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                }
            });

            // Handle edit category modal
            $('.edit-category').on('click', function() {
                $('#editCategoryId').val($(this).data('id'));
                $('#editCategoryName').val($(this).data('name'));
                $('#editCategorySlug').val($(this).data('slug'));
                $('#editCategoryDescription').val($(this).data('description'));
            });

            // Handle delete category modal
            $('.delete-category').on('click', function() {
                $('#deleteCategoryId').val($(this).data('id'));
                $('#deleteCategoryName').text($(this).data('name'));
            });
        });
    </script>
@endsection
