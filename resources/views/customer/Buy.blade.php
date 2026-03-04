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

@if($cart && $cart->items->count() > 0)
    <table>
        <tr>
            <th>الصورة</th>
            <th>اسم المنتج</th>
            <th>السعر</th>
            <th>الكمية</th>
            <th>الإجمالي</th>
            <th>حذف</th>
        </tr>

        @foreach($cart->items as $item)
        <tr>
            <td>
                <img src="{{ asset('storage/' . $item->product->image) }}" 
                     alt="{{ $item->product->name }}">
            </td>
            <td>{{ $item->product->name }}</td>
            <td>{{ number_format($item->price) }} ج.م</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price * $item->quantity) }} ج.م</td>
            <td>
                <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    @php
        $total = $cart->items->sum(function($item) {
            return $item->price * $item->quantity;
        });
    @endphp
    
    <h3>الإجمالي: {{ number_format($total) }} ج.م</h3>
    
    <form action="{{ route('cart.buy', $cart->id) }}" method="POST">
        @csrf
        
        <div>
            <label for="address">العنوان</label>
            <input class="form-control" type="text" name="address" id="address" value="{{ old('address') }}" required>
        </div>
        
        <div>
            <label for="phone">رقم الموبايل للتواصل</label>
            <input class="form-control" type="text" name="phone" id="phone" value="{{ old('phone') }}" required>
        </div>
        
        <div>
            <label for="website_url">رابط الموقع</label>
            <input class="form-control" type="url" name="website_url" id="website_url" value="{{ old('website_url') }}" placeholder="https://example.com" required>
        </div>
        
        <input type="hidden" name="total_price" value="{{ $total }}">
        
        <button type="submit" class="btn btn-success">شراء</button>
    </form>

@else
    <p>السلة فاضية</p>
@endif

</body>
</html>