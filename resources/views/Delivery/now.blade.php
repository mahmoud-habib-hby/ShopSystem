<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الطلبات الحالية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="{{ route('delivery.work') }}">work</a>
<a href="{{ route('delivery.past') }}">past</a>
<div class="container mt-5">
    <h2 class="mb-4">الطلبات الحالية (Pending)</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info">لا توجد طلبات حالياً.</div>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>اسم العميل</th>
                    <th>المبلغ</th>
                    <th>تاريخ الطلب</th>
                    <th>التفاصيل</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name ?? 'غير معروف' }}</td>
                    <td>{{ $order->total_price ?? '0' }} ج.م</td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('delivery.show',$order->id) }}" class="btn btn-sm btn-primary">التفاصيل</a>
                    </td>
                    <td>
                        <a href="{{ route('delivery.add',$order->id) }}" class="btn btn-sm btn-primary">اخذ هذا الطلب</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</body>
</html>