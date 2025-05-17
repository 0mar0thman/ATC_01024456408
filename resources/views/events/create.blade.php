@extends('layouts.master')
@section('title', 'إضافة فعالية جديدة')
 <link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفعاليات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة فعالية</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">إضافة فعالية جديدة</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>اسم الفعالية</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>التصنيف</label>
                                    <select name="category_id" class="form-control" required>
                                        <option value="">اختر تصنيف</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>تاريخ الفعالية</label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>المكان</label>
                                    <input type="text" name="venue" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>السعر (ر.س)</label>
                                    <input type="number" name="price" class="form-control" min="0" required>
                                </div>
                                <div class="form-group">
                                    <label>السعة (عدد الأشخاص)</label>
                                    <input type="number" name="capacity" class="form-control" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>صورة الفعالية</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>
                                <div class="form-group">
                                    <label>التصنيف</label>
                                    <select name="is_featured" id="is_featured">
                                        <option value="0">عادي</option>
                                        <option value="1">مميز</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>وصف الفعالية</label>
                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <a href="{{ route('events.index') }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
