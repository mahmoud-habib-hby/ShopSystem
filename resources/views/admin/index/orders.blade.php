<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>طلبات المندوب</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

.badge-paid{
    background:#16a34a;
    color:white;
    font-weight:500;
}

.badge-unpaid{
    background:#ef4444;
    color:white;
    font-weight:500;
}

.badge-collected{
    background:#f59e0b;
    color:white;
    font-weight:500;
}

.card-header a{
    text-decoration:none;
    color:#2563eb;
    font-weight:500;
}

.table thead{
    background:#e2e8f0;
}

.table tfoot{
    background:#e2e8f0;
    font-weight:600;
}

</style>
</head>
<body>

<div class="container my-4">

    <!-- عنوان الصفحة -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="mb-0">
                <i class="fas fa-truck text-primary"></i>
                طلبات المندوب
            </h4>
        </div>
    </div>

    <!-- نموذج البحث -->
    <form method="GET" action="{{ route('admin.search') }}" class="mb-4 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="ابحث عن منتج" value="{{ $search ?? '' }}">
        <button type="submit" class="btn btn-primary">بحث</button>
    </form>

    @php
        $Orders = $search_order ?? $orders ?? [];
    @endphp

    @forelse($Orders as $order)
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <span class="fw-bold">طلب #{{ $order->id }}</span>
                    <span class="badge bg-info ms-2">{{ $order->created_at->format('Y-m-d') }}</span>
                </div>
                <div class="d-flex align-items-center">
                    @if($order->payment_status == 'unpaid')
                        <span class="badge badge-unpaid me-2">{{ $order->payment_status }}</span>
                    @elseif($order->payment_status == 'collected')
                        <span class="badge badge-collected me-2">{{ $order->payment_status }}</span>
                    @else
                        <span class="badge badge-paid me-2">{{ $order->payment_status }}</span>
                    @endif
                    <a href="{{ route('admin.money',$order->id) }}">تم تحصيل المال</a>
                </div>
            </div>
            
            <div class="card-body">
                <!-- معلومات العميل والدليفري -->
                <div class="mb-3">
                    <small class="text-muted d-block">
                        <i class="fas fa-user"></i> {{ $order->customer->name ?? 'عميل' }}
                    </small>
                    <small class="text-muted">
                        <i class="fas fa-phone"></i> {{ $order->delivery->name ?? 'لا يوجد' }}
                    </small>
                </div>

                <!-- جدول المنتجات -->
                <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>المجموع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'منتج' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price) }} $</td>
                            <td>{{ number_format($item->price * $item->quantity) }} $</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-start">الإجمالي:</td>
                            <td class="text-success">{{ number_format($order->total_price) }} $</td>
                        </tr>
                    </tfoot>
                </table>
                </div>
            </div>
        </div>
    @empty
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h6 class="text-muted">لا توجد طلبات لهذا المندوب</h6>
            </div>
        </div>
    @endforelse
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>