@extends('layouts.master')
@section('title', 'تعديل فعالية')
<link rel="stylesheet" href="{{ asset('assets/css/container/container.css') }}">
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفعاليات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل فعالية</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">تعديل فعالية: {{ $event->title }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>اسم الفعالية</label>
                                    <input type="text" name="title" class="form-control" value="{{ $event->title }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>التصنيف</label>
                                    <select name="category_id" class="form-control" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $event->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>تاريخ الفعالية</label>
                                    <input type="datetime-local" name="date" class="form-control"
                                        value="{{ old('date', $event->date ? \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                                        required>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>المكان</label>
                                    <input type="text" name="venue" class="form-control" value="{{ $event->venue }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>السعر (ر.س)</label>
                                    <input type="number" name="price" class="form-control" value="{{ $event->price }}"
                                        min="0" required>
                                </div>
                                <div class="form-group">
                                    <label>السعة (عدد الأشخاص)</label>
                                    <input type="number" name="capacity" class="form-control"
                                        value="{{ $event->capacity }}" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>صورة الفعالية</label>
                                    @if ($event->image)
                                        <div class="mb-2 w-25">
                                            {{-- <img src="{{ $event->image ? asset('Attachments/Events/' . $event->image) : asset('images/default-event.jpg') }}"
                                                class="event-img" alt="{{ $event->name }}"> --}}
                                            <img src="{{ $event->image ?? asset('images/default-event.jpg') }}"
                                                class="event-img" alt="{{ $event->title }}">
                                        </div>
                                    @endif
                                    @if ($event->image)
                                        <small class="form-text text-muted mt-1">الصورة الحالية:
                                            {{ basename($event->image) }}</small>
                                    @endif
                                    <input type="file" name="image" class="form-control" accept="image/*"
                                        value="">
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
                                    <textarea name="description" class="form-control" rows="3">{{ $event->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">تحديث</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
