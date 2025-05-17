<link href="{{ URL::asset('assets/css/bookings_user/create.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@extends('layouts.master')

@section('title', 'حجز الفعالية')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>حجز فعالية: {{ $event->title }}</h4>
                    </div>
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <input type="hidden" name="user_id" value="{{ \Illuminate\Support\Facades\Auth::id() }}">
                    <div class="card-body">
                        <form action="{{ route('user.bookings.store', $event) }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">اسم الفعالية</label>
                                    <input type="text" class="form-control" value="{{ $event->title }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">التاريخ والوقت</label>
                                    <input type="text" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($event->time)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">المكان</label>
                                    <input type="text" class="form-control" value="{{ $event->venue }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">السعر لكل تذكرة</label>
                                    <input type="text" class="form-control"
                                        value="{{ $event->price > 0 ? number_format($event->price) . ' ج.م' : 'مجاني' }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tickets" class="form-label">عدد التذاكر</label>
                                    <select name="tickets" id="tickets" class="form-select" required>
                                        @for ($i = 1; $i <= min($event->capacity, 10); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <small class="text-muted">المقاعد المتاحة: {{ $event->capacity }}</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="payment_method" class="form-label">طريقة الدفع</label>
                                    <select name="payment_method" id="payment_method" class="form-select" required>
                                        <option value="credit_card">بطاقة ائتمان</option>
                                        <option value="paypal">باي بال</option>
                                        <option value="bank_transfer">تحويل بنكي</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <h5>المجموع: <span id="total-price" name="total_price">{{ number_format($event->price) }}</span> ج.م
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">تأكيد الحجز والدفع</button>
                                <a href="{{ route('user.bookings.index') }}" class="btn btn-outline-secondary">حجوزاتك</a>
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">عودة</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ticketsSelect = document.getElementById('tickets');
            const totalPriceElement = document.getElementById('total-price');
            const pricePerTicket = {{ $event->price }};

            ticketsSelect.addEventListener('change', function() {
                const total = pricePerTicket * this.value;
                totalPriceElement.textContent = total.toLocaleString();
            });
        });
    </script>
@endsection
