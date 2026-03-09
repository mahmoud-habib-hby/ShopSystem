<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلبات المندوب</title>
    <!-- Bootstrap RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
</head>
<body class="bg-light">

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

    @forelse($orders as $order)
        <!-- بطاقة الطلب -->
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">طلب #{{ $order->id }}</span>
                    <span class="badge bg-info">{{ $order->created_at->format('Y-m-d') }}</span>
                    <span class="badge bg-info">{{ $order->payment_status}}</span>
                    <a href="{{ route("admin.money",$order->id) }}">تم تحصيل المال</a>
                </div>
            </div>
            
            <div class="card-body">
                <!-- معلومات بسيطة -->
                <div class="mb-3">
                    <small class="text-muted d-block">
                        <i class="fas fa-user"></i> {{ $order->customer->name ?? 'عميل' }}
                    </small>
                    <small class="text-muted">
                        <i class="fas fa-phone"></i> {{ $order->delivery->name ?? 'لا يوجد' }}
                    </small>
                </div>

                <!-- جدول المنتجات -->
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
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
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-start fw-bold">الإجمالي:</td>
                            <td class="fw-bold text-success">{{ number_format($order->total_price) }} $</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @empty
        <!-- لا توجد طلبات -->
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h6 class="text-muted">لا توجد طلبات لهذا المندوب</h6>
            </div>
        </div>
    @endforelse
</div>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>