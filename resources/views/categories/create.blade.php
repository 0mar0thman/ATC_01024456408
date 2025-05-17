@extends('layouts.master')
@section('title', 'إضافة تصنيف جديد')
<link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">التصنيفات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة تصنيف</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">إضافة تصنيف جديد</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>اسم التصنيف</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label>الرابط (Slug)</label>
                                    <input type="text" name="slug" class="form-control" required>
                                    <small class="text-muted">يجب أن يكون فريداً ويحتوي على حروف لاتينية فقط</small>
                                </div>
                            </div> --}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>الوصف</label>
                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
