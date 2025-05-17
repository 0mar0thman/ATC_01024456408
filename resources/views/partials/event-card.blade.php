<div class="card mb-3">
    <img src="{{ $event->image_url ?? 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $event->name }}">
    <div class="card-body">
        <h5 class="card-title">{{ $event->name }}</h5>
        <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
        <p class="card-text"><small class="text-muted">التاريخ: {{ $event->date->format('Y-m-d') }}</small></p>
        <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary btn-sm">عرض التفاصيل</a>
    </div>
</div>
