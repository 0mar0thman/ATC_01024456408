<link href="{{ URL::asset('assets/css/bookings_user/index.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@extends('layouts.master')

@section('title', 'حجوزاتي')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">حجوزاتي</h4>
                        <div class="btn-group">
                            <a href="{{ url('/user/bookings?status=all') }}"
                                class="btn btn-sm fw-bolder {{ $status == 'all' ? 'btn-warning' : 'btn-outline-warning' }}">الكل</a>
                            <a href="{{ url('/user/bookings?status=confirmed') }}"
                                class="btn btn-sm fw-bolder {{ $status == 'confirmed' ? 'btn-warning' : 'btn-outline-warning' }}">المؤكدة</a>
                            <a href="{{ url('/user/bookings?status=cancelled') }}"
                                class="btn btn-sm fw-bolder {{ $status == 'cancelled' ? 'btn-warning' : 'btn-outline-warning' }}">الملغاة</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($bookings->isEmpty())
                            <div class="alert alert-info text-center">
                                <h5>لا توجد لديك أي حجوزات</h5>
                                <p>يمكنك استكشاف الفعاليات المتاحة وحجز تذاكرك</p>
                                <a href="{{ route('user.home') }}" class="btn btn-primary">استكشاف الفعاليات</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                @if ($bookings->isEmpty())
                                    <div class="text-center py-5">
                                        <div class="empty-state">
                                            <img src="{{ asset('assets/img/empty-bookings.svg') }}" alt="لا توجد حجوزات"
                                                class="img-fluid mb-4" width="300">
                                            <h4 class="mb-3">لا توجد لديك أي حجوزات</h4>
                                            <p class="text-muted mb-4">يمكنك استكشاف الفعاليات المتاحة وحجز تذاكرك</p>
                                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                                                <i class="fas fa-calendar-alt me-2"></i> استكشاف الفعاليات
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="25%">الفعالية</th>
                                                <th width="15%">التاريخ</th>
                                                <th width="10%">التذاكر</th>
                                                <th width="15%">المجموع</th>
                                                <th width="10%">الحالة</th>
                                                <th width="20%">الإجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bookings as $booking)
                                                <tr class="{{ $booking->status == 'cancelled' ? 'table-secondary' : '' }}">
                                                    <td>#{{ $booking->id }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">

                                                            <span>{{ Str::limit($booking->event->title, 30) }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $booking->event->date->format('d/m/Y') }}
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ $booking->event->date->diffForHumans() }}
                                                        </small>
                                                    </td>
                                                    <td>{{ $booking->tickets }}</td>
                                                    <td>{{ number_format($booking->total_price) }} ر.س</td>
                                                    <td>
                                                        @if ($booking->status == 'confirmed')
                                                            <span class="badge bg-success">مؤكد</span>
                                                        @else
                                                            <span class="badge bg-danger">ملغى</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('bookings.show', $booking) }}"
                                                                class="btn btn-sm btn-outline-primary" title="التفاصيل">
                                                                <i class="fas fa-eye"></i>
                                                            </a>

                                                            @if ($booking->status == 'confirmed' && $booking->event->date > now()->addDays(2))
                                                                <form action="{{ route('bookings.cancel', $booking) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-outline-danger"
                                                                        title="إلغاء الحجز"
                                                                        onclick="return confirm('هل أنت متأكد من إلغاء الحجز؟')">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </form>
                                                            @endif

                                                            @if ($booking->status == 'confirmed')
                                                                <a href="{{ route('bookings.download', $booking) }}"
                                                                    class="btn btn-sm btn-outline-secondary"
                                                                    title="تحميل التذكرة" target="_blank">
                                                                    <i class="fas fa-download"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> رجوع
                                </a>
                            </div>

                            <div class="mt-4">
                                {{ $bookings->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تأكيد الإلغاء
            const cancelForms = document.querySelectorAll('form[action*="cancel"]');
            cancelForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm('هل أنت متأكد من رغبتك في إلغاء هذا الحجز؟')) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endsection
