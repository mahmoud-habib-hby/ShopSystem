<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الطلبات السابقة</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body dir="rtl">

<div class="container mt-5">

    <h2 class="mb-4 text-center">الطلبات السابقة</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info text-center">
            لا يوجد طلبات سابقة
        </div>
    @else
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>السعر الكلي</th>
                    <th>الحالة</th>
                    <th>حالة الدفع</th>
                    <th>العنوان</th>
                    <th>تاريخ الطلب</th>
                    <th>التفاصيل</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->total_price }} جنيه</td>

                        <td>
                            @if($order->status == 'delivered')
                                <span class="badge bg-success">تم التوصيل</span>
                            @elseif($order->status == 'received')
                                <span class="badge bg-primary">تم الاستلام</span>
                            @else
                                <span class="badge bg-secondary">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td>
                            @if($order->payment_status == 'unpaid')
                                <span class="badge bg-danger">غير مدفوع</span>
                            @elseif($order->payment_status == 'collected')
                                <span class="badge bg-warning text-dark">تم التحصيل</span>
                            @elseif($order->payment_status == 'settled')
                                <span class="badge bg-success">تم التسوية</span>
                            @endif
                        </td>

                        <td>{{ $order->address }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        <td> <a href="{{ route('delivery.show',$order->id) }}">التفاصيل</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>

</body>
</html>