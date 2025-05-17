<link href="{{ URL::asset('assets/css/bookings_user/show.css') }}" rel="stylesheet" />
@extends('layouts.master')

@section('title', 'تفاصيل الحجز')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>تفاصيل الحجز #{{ $booking->id }}</h4>
                    </div>
                    <div id="print-section">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h5>معلومات الفعالية</h5>
                                        <ul class="list-unstyled">
                                            <li><strong>الاسم:</strong> {{ $booking->event->title }}</li>
                                            <li><strong>التاريخ:</strong>
                                                {{ \Carbon\Carbon::parse($booking->event->date)->format('d/m/Y') }}</li>
                                            <li><strong>الوقت:</strong>
                                                {{ \Carbon\Carbon::parse($booking->event->time)->format('h:i A') }}</li>
                                            <li><strong>المكان:</strong> {{ $booking->event->venue }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>معلومات الحجز</h5>
                                        <ul class="list-unstyled">
                                            <li><strong>رقم الحجز:</strong> #{{ $booking->id }}</li>
                                            <li><strong>تاريخ الحجز:</strong> {{ $booking->created_at->format('d/m/Y') }}
                                            </li>
                                            <li><strong>عدد التذاكر:</strong> {{ $booking->tickets }}</li>
                                            <li><strong>المجموع:</strong> {{ number_format($booking->total_price) }} ج.م
                                            </li>
                                            <li><strong>طريقة الدفع:</strong>
                                                @if ($booking->payment_method == 'credit_card')
                                                    بطاقة ائتمان
                                                @elseif($booking->payment_method == 'paypal')
                                                    باي بال
                                                @elseif($booking->payment_method == 'bank_transfer')
                                                    تحويل بنكي
                                                @endif
                                            </li>
                                            <li><strong>الحالة:</strong>
                                                @if ($booking->status == 'confirmed')
                                                    <span class="badge bg-success">مؤكد</span>
                                                @else
                                                    <span class="badge bg-danger">ملغى</span>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <h5>تعليمات الحضور</h5>
                                    <p>يرجى إحضار رقم الحجز وبطاقة الهوية عند الحضور للفعالية. يمكنك عرض هذه الصفحة على
                                        هاتفك أو
                                        طباعة التذكرة.</p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('user.bookings.index') }}" class="btn btn-outline-secondary no-print">عودة إلى
                                        الحجوزات</a>
                                    <a href="javascript:void(0);" onclick="printTicket()" class="btn btn-primary no-print">طباعة
                                        التذكرة</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function printTicket() {
            const printContents = document.getElementById('print-section').innerHTML;
            const originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload(); // لإعادة تحميل الصفحة بعد الطباعة
        }
    </script>
@endsection
