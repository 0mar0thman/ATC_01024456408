@csrf

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>اسم الفعالية</label>
            <input type="text" name="title" class="form-control" value="{{ $event->title ?? old('title') }}" required>
        </div>
        <div class="form-group">
            <label>التصنيف</label>
            <select name="category_id" class="form-control" required>
                <option value="">اختر تصنيف</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ ($event->category_id ?? old('category_id')) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>تاريخ الفعالية</label>
            <input type="date" name="date" class="form-control"
                   value="{{ isset($event) ? $event->date->format('Y-m-d') : old('date') }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>المكان</label>
            <input type="text" name="venue" class="form-control"
                   value="{{ $event->venue ?? old('venue') }}" required>
        </div>
        <div class="form-group">
            <label>السعر (ر.س)</label>
            <input type="number" name="price" class="form-control"
                   value="{{ $event->price ?? old('price') }}" min="0" required>
        </div>
        <div class="form-group">
            <label>السعة (عدد الأشخاص)</label>
            <input type="number" name="capacity" class="form-control"
                   value="{{ $event->capacity ?? old('capacity') }}" min="1" required>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>صورة الفعالية</label>
            @if(isset($event) && $event->image)
            <div class="mb-2">
                <img src="{{ asset('storage/'.$event->image) }}" width="100" class="img-thumbnail">
            </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div class="form-group">
            <label>وصف الفعالية</label>
            <textarea name="description" class="form-control" rows="3">{{ $event->description ?? old('description') }}</textarea>
        </div>
    </div>
</div>
