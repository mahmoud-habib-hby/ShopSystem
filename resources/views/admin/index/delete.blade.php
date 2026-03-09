<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>المنتجات المحذوفة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
        
        .navbar {
            background: #343a40;
            padding: 0.8rem;
        }
        
        .navbar a {
            color: white !important;
            margin-left: 15px;
            text-decoration: none;
        }
        
        .product-card {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .product-info {
            flex: 1;
        }
        
        .product-name {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 0.3rem;
        }
        
        .product-details {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .badge-deleted {
            background: #dc3545;
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.8rem;
        }
        
        .btn-action {
            padding: 0.3rem 1rem;
            border-radius: 5px;
            border: none;
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        .btn-restore {
            background: #28a745;
            color: white;
        }
        
        .btn-restore:hover {
            background: #218838;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c82333;
        }
        
        .stats-box {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-around;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-number {
            font-size: 1.8rem;
            font-weight: bold;
            color: #007bff;
        }
        
        .empty-message {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<!-- Navbar بسيط -->
<nav class="navbar">
    <div class="container">
        <div>
            <a href="{{ route('product.index') }}"><i class="fas fa-box ms-1"></i> المنتجات</a>
            <a href="{{ route('admin.orders') }}"><i class="fas fa-shopping-cart ms-1"></i> الطلبات</a>
            <a href="{{ route('admin.deliveries') }}"><i class="fas fa-truck ms-1"></i> المندوبين</a>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="fas fa-sign-out-alt ms-1"></i> خروج
            </button>
        </form>
    </div>
</nav>

<div class="container mt-4">

    <!-- عنوان الصفحة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4><i class="fas fa-trash-alt text-danger ms-2"></i>المنتجات المحذوفة</h4>
        <span class="badge bg-danger">عدد المحذوف: {{ $product->count() }}</span>
    </div>

    <!-- رسائل النجاح/الخطأ -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- إحصائيات سريعة -->
    @if($product->count() > 0)
    <div class="stats-box">
        <div class="stat">
            <div class="stat-number">{{ $product->count() }}</div>
            <div class="text-muted">منتجات</div>
        </div>
        <div class="stat">
            <div class="stat-number">{{ $product->sum('stock') }}</div>
            <div class="text-muted">قطع</div>
        </div>
        <div class="stat">
            <div class="stat-number">{{ $product->sum('price') }}$</div>
            <div class="text-muted">قيمة</div>
        </div>
    </div>
    @endif

    <!-- قائمة المنتجات -->
    @forelse($product as $item)
    <div class="product-card">
        <!-- صورة المنتج -->
        <div>
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="product-img" alt="">
            @else
                <div class="product-img bg-light d-flex align-items-center justify-content-center">
                    <i class="fas fa-image text-muted"></i>
                </div>
            @endif
        </div>
        
        <!-- معلومات المنتج -->
        <div class="product-info">
            <div class="d-flex align-items-center gap-2">
                <span class="product-name">{{ $item->name }}</span>
                <span class="badge-deleted">محذوف</span>
            </div>
            <div class="product-details">
                <span class="ms-3"><i class="fas fa-tag ms-1"></i>${{ $item->price }}</span>
                <span class="ms-3"><i class="fas fa-boxes ms-1"></i>الكمية: {{ $item->stock }}</span>
                <span><i class="fas fa-tag ms-1"></i>{{ $item->category ?? 'بدون تصنيف' }}</span>
            </div>
        </div>
        
        <!-- أزرار التحكم -->
        <div class="d-flex gap-2">
            <a href="{{ route('product.active', $item->id) }}" 
               class="btn-action btn-restore"
               onclick="return confirm('استعادة هذا المنتج؟')">
                <i class="fas fa-undo-alt"></i> استعادة
            </a>

        </div>
    </div>
    @empty
    <!-- حالة عدم وجود منتجات -->
    <div class="empty-message">
        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
        <h5>لا توجد منتجات محذوفة</h5>
        <p class="text-muted">سلة المهملات فارغة</p>
        <a href="{{ route('product.index') }}" class="btn btn-primary btn-sm">
            العودة للمنتجات
        </a>
    </div>
    @endforelse

    <!-- زر العودة -->
    <div class="text-center mt-4">
        <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-right ms-1"></i> رجوع
        </a>
    </div>

</div>

</body>
</html>