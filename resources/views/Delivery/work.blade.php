<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>الطلبات المخصصة لك</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f5f7fb;
}

.card{
    border:none;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.status-pending{
    background:#facc15;
    color:#000;
    font-weight:500;
    padding:3px 8px;
    border-radius:6px;
    font-size:0.9rem;
}

.status-delivered{
    background:#16a34a;
    color:white;
    font-weight:500;
    padding:3px 8px;
    border-radius:6px;
    font-size:0.9rem;
}

.btn-action{
    margin-right:5px;
}

.success-message{
    background:#16a34a;
    color:white;
    padding:10px;
    border-radius:6px;
    text-align:center;
    margin-bottom:15px;
    font-weight:500;
}
</style>

</head>
<body>

<div class="container mt-5">

@if(session('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
@endif

<h3 class="mb-4 fw-bold text-center">الطلبات المخصصة لك</h3>

@if($orders->isEmpty())
    <div class="alert alert-info text-center">لا توجد طلبات حالياً.</div>
@else
<div class="row">
    @foreach($orders as $order)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold">العميل: {{ $order->customer->name ?? 'غير معروف' }}</h5>
                <p class="card-text mb-2">
                    <strong>السعر:</strong> {{ $order->total_price ?? 0 }} ج.م
                </p>
                <p class="mb-2">
                    <strong>حالة الطلب:</strong>
                    @if($order->status=="delivered")
                        <span class="status-delivered">تم التوصيل</span>
                    @else
                        <span class="status-pending">{{ $order->status }}</span>
                    @endif
                </p>

                @if ($order->status != "delivered")
                <div class="mt-3 d-flex flex-wrap">
                    <a href="{{ route('delivery.delivered',$order->id) }}" class="btn btn-success btn-sm btn-action">
                        تم توصيله
                    </a>
                    <a href="{{ route('delivery.money',$order->id) }}" class="btn btn-primary btn-sm btn-action">
                        تم أخذ المال
                    </a>
                </div>
                @else
                    <p class="text-success fw-bold mt-2">انتظر تأكيد العميل</p>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>