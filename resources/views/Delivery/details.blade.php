<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سلتي</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
        img { width: 80px; height: 80px; object-fit: cover; }
        .btn { padding: 5px 10px; text-decoration: none; color: white; border-radius: 5px; display: inline-block; border: none; cursor: pointer; }
        .btn-danger { background: red; }
        .btn-success { background: green; }
        .alert-success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .alert-danger { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; list-style: none; }
        .form-control { width: 100%; padding: 8px; margin: 5px 0 15px 0; border: 1px solid #ddd; border-radius: 4px; }
        label { font-weight: bold; }
    </style>
</head>
<body>

<h1>🛒 سلة التسوق</h1>

<!-- رسائل النجاح -->
@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- رسائل الخطأ -->
@if($errors->any())
    <ul class="alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

@if($orderItems && $orderItems->count() > 0)
    <table>
        <tr>
            <th>الصورة</th>
            <th>اسم المنتج</th>
            <th>السعر</th>
            <th>الكمية</th>
            <th>الإجمالي</th>
        </tr>

        @foreach($orderItems as $item)
        <tr>
            <td>
                <img src="{{ asset('storage/' . $item->product->image) }}" 
                     alt="{{ $item->product->name }}">
            </td>
            <td>{{ $item->product->name }}</td>
            <td>{{ number_format($item->price) }} ج.م</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price * $item->quantity) }} ج.م</td>
        </tr>
        @endforeach
    </table>

    @php
        $total = $orderItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
    @endphp
    
    <h3>الإجمالي: {{ number_format($total) }} ج.م</h3>
    

@else
    <p>السلة فاضية</p>
@endif

</body>
</html>