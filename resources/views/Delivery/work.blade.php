<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الطلبات المخصصة لك</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
    @if($orders->isEmpty())
        <div class="alert alert-info">لا توجد طلبات حالياً.</div>
    @else
        <div class="row">
            @foreach($orders as $order)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">اسم المستخدم :{{ $order->customer->name}}</h5>
                        <p class="card-text">
                            السعر: {{ $order->total_price ?? 0 }} ج.م<br>
                            حالة الطلب: {{ $order->status }}
                        </p>
                        @if ($order->status=="delivered")
                            <p class="text-success fw-bolder">انتظر تم يؤكد المستخدم</p>
                        @else
                        <a href="{{ route('delivery.delivered',$order->id) }}">تم توصيله</a>
                            
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
</body>
</html>