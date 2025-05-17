@extends('layouts.master')
@section('title', 'تعديل تصنيف')
 <link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">التصنيفات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل تصنيف</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">تعديل تصنيف: {{ $category->name }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>اسم التصنيف</label>
                                <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label>الرابط (Slug)</label>
                                <input type="text" name="slug" class="form-control" value="{{ $category->slug }}" required>
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>الوصف</label>
                                <textarea name="description" class="form-control" rows="3">{{ $category->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">تحديث</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
