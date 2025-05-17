@csrf

@if(isset($category) && $category->id)
    @method('PUT')
@endif

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>اسم التصنيف</label>
            <input type="text" name="name" class="form-control"
                   value="{{ $category->name ?? old('name') }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>الرابط (Slug)</label>
            <input type="text" name="slug" class="form-control"
                   value="{{ $category->slug ?? old('slug') }}" required>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>الوصف</label>
            <textarea name="description" class="form-control" rows="3">{{ $category->description ?? old('description') }}</textarea>
        </div>
    </div>
</div>
