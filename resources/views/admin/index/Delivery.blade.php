<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الدليفري</title>
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
        .delivery-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .delivery-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .delivery-id {
            font-weight: bold;
            color: #007bff;
        }
        .info-row {
            margin-bottom: 8px;
            font-size: 14px;
        }
        .label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 100px;
        }
        .value {
            color: #333;
        }
        .no-deliveries {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            color: #666;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 13px;
        }
        .btn:hover {
            background: #0056b3;
        }
        form.search-form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 5px;
        }
        form.search-form input[type="text"] {
            padding: 5px 10px;
            width: 200px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🚚 قائمة الدليفري</h1>

    {{-- نموذج البحث --}}
    <form method="GET" action="{{ route('admin.search_delivery') }}" class="search-form">
        <input type="text" name="search" placeholder="ادخل ID الدليفري">
        <button type="submit" class="btn">بحث</button>
    </form>

    {{-- تحقق من الرسائل --}}
    @if(session('success'))
        <div class="success-message" style="background:#d4edda;color:#155724;padding:10px;border-radius:5px;text-align:center;margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    @php
        // دعم المتغير سواء جاء من $deliveries أو $search_delivery
        $allDeliveries = $deliveries ?? $search_delivery ?? collect();
    @endphp

    @if($allDeliveries->isEmpty())
        <div class="no-deliveries">
            لا يوجد دليفري
        </div>
    @else
        @foreach($allDeliveries as $delivery)
            <div class="delivery-card">
                <div class="delivery-header">
                    <span class="delivery-id">ID: {{ $delivery->id }}</span>
                    <a href="{{ route('admin.details', $delivery->id) }}" class="btn">عرض التفاصيل</a>
                </div>

                <div class="info-row">
                    <span class="label">الاسم:</span>
                    <span class="value">{{ $delivery->name }}</span>
                </div>

                <div class="info-row">
                    <span class="label">الإيميل:</span>
                    <span class="value">{{ $delivery->email }}</span>
                </div>

                <div class="info-row">
                    <span class="label">تاريخ التسجيل:</span>
                    <span class="value">{{ $delivery->created_at->format('Y-m-d') }}</span>
                </div>
            </div>
        @endforeach
    @endif
</div>
</body>
</html>