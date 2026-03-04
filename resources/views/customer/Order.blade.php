<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طلباتي</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .order-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .order-id {
            font-weight: bold;
            color: #007bff;
        }
        .order-status {
            background: #e7f3ff;
            color: #007bff;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 14px;
        }
        .info-row {
            margin-bottom: 8px;
            font-size: 14px;
        }
        .label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 80px;
        }
        .value {
            color: #333;
        }
        .website-link {
            color: #007bff;
            text-decoration: none;
            word-break: break-all;
        }
        .website-link:hover {
            text-decoration: underline;
        }
        .products {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .product-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px dashed #ddd;
        }
        .product-item:last-child {
            border-bottom: none;
        }
        .total-price {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
            text-align: left;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
        .no-orders {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 طلباتي</h1>
        
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        
        @if(isset($orders) && count($orders) > 0)
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <span class="order-id">طلب رقم: #{{ $order->id }}</span>
                        <span class="order-status">{{ $order->status }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="label">التاريخ:</span>
                        <span class="value">{{ $order->created_at->format('Y-m-d') }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="label">العنوان:</span>
                        <span class="value">{{ $order->address }}</span>
                    </div>
                    
                    @if($order->phone)
                    <div class="info-row">
                        <span class="label">الهاتف:</span>
                        <span class="value">{{ $order->phone }}</span>
                    </div>
                    @endif
                    
                    @if($order->website_url)
                    <div class="info-row">
                        <span class="label">الموقع:</span>
                        <span class="value">
                            <a href="{{ $order->website_url }}" target="_blank" class="website-link">
                                {{ $order->website_url }}
                            </a>
                        </span>
                    </div>
                    @endif
                    
                    <div class="info-row">
                        <span class="label">الدفع:</span>
                        <span class="value">
                            @if($order->payment_status == 'unpaid')
                                غير مدفوع
                            @elseif($order->payment_status == 'collected')
                                تم التحصيل
                            @else
                                تم التسوية
                            @endif
                        </span>
                    </div>
                    
                    <div class="products">
                        <div style="font-weight: bold; margin-bottom: 8px;">المنتجات:</div>
                        @foreach($order->items as $item)
                            <div class="product-item">
                                <span>{{ $item->product->name }}</span>
                                <span>{{ $item->quantity }} × {{ number_format($item->price) }} ج.م</span>
                                <span style="color: #28a745;">{{ number_format($item->price * $item->quantity) }} ج.م</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="total-price">
                        الإجمالي: {{ number_format($order->total_price) }} ج.م
                    </div>
                    @if ($order->status=="delivered")
                        <a href="{{ route('customer.received',$order->id) }}">تم الاستلام</a>
                    @endif
                </div>
            @endforeach
        @else
            <div class="no-orders">
                <p style="font-size: 16px; color: #666;">لا توجد طلبات حتى الآن</p>
                {{-- <a href="{{ route('customer.products') }}" class="btn">تسوق الآن</a> --}}
            </div>
        @endif
    </div>
</body>
</html>