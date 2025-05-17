<!DOCTYPE html>
<html>
<head>
    <title>تذكرة الفعالية</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .ticket { border: 2px dashed #000; padding: 20px; max-width: 500px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .details { margin-bottom: 15px; }
        .barcode { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h2>تذكرة الدخول</h2>
            <h3>{{ $booking->event->title }}</h3>
        </div>

        <div class="details">
            <p><strong>رقم الحجز:</strong> #{{ $booking->id }}</p>
            <p><strong>الاسم:</strong> {{ $booking->user->name }}</p>
            <p><strong>تاريخ الفعالية:</strong> {{ $booking->event->date->format('Y-m-d') }}</p>
            <p><strong>عدد التذاكر:</strong> {{ $booking->tickets }}</p>
        </div>

        <div class="barcode">
            <p>باركود الحجز: {{ time() }}</p>
            <!-- يمكن إضافة صورة باركود حقيقية هنا -->
        </div>
    </div>
</body>
</html>
