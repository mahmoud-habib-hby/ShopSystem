<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>الطلبات الحالية</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f5f7fb;
}

.navbar{
background:#1e293b;
}

.navbar a{
color:white !important;
margin-left:20px;
font-weight:500;
}

.card{
border:none;
border-radius:12px;
box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

.table thead{
background:#334155;
color:white;
}

.btn-take{
background:#16a34a;
color:white;
}

.btn-details{
background:#2563eb;
color:white;
}

</style>

</head>

<body>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-danger">تسجيل الخروج</button>
</form>
<!-- Navbar -->
<nav class="navbar p-3 mb-4">
<div class="container">

<a href="{{ route('delivery.work') }}">الطلبات الحالية</a>
<a href="{{ route('delivery.past') }}">الطلبات السابقة</a>

</div>
</nav>

<div class="container">

<div class="card">

<div class="card-body">

<h4 class="mb-4 fw-bold">الطلبات الحالية</h4>

@if($orders->isEmpty())

<div class="alert alert-info text-center">
لا توجد طلبات حالياً
</div>

@else

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>
<tr>
<th>#</th>
<th>اسم العميل</th>
<th>المبلغ</th>
<th>تاريخ الطلب</th>
<th>التفاصيل</th>
<th>الإجراء</th>
</tr>
</thead>

<tbody>

@foreach($orders as $order)

<tr>

<td>{{ $order->id }}</td>

<td>{{ $order->customer->name ?? 'غير معروف' }}</td>

<td class="text-success fw-bold">
{{ $order->total_price ?? '0' }} ج.م
</td>

<td>{{ $order->created_at->format('Y-m-d') }}</td>

<td>
<a href="{{ route('delivery.show',$order->id) }}" class="btn btn-sm btn-details">
عرض
</a>
</td>

<td>
<a href="{{ route('delivery.add',$order->id) }}" class="btn btn-sm btn-take">
استلام الطلب
</a>
</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endif

</div>

</div>

</div>

</body>
</html>