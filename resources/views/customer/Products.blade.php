<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>كل المنتجات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">متجري</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item me-2">
                    <a href="{{ route('customer.cart') }}" class="btn btn-warning">السلة</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customer.order') }}" class="btn btn-info">طلباتي</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">

    <!-- عنوان الصفحة -->
    <h1 class="mb-4">كل المنتجات</h1>
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">تسجيل الخروج</button>
    </form>
    
    <!-- Search Form -->
    <form method="GET" action="{{ route('customer.search') }}" class="mb-4 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="ابحث عن منتج" value="{{ $search ?? '' }}">
        <button type="submit" class="btn btn-primary">بحث</button>
    </form>

    <!-- عرض المنتجات -->
    <div class="row">
        @php
            $display_products = $search_products ?? $products;
        @endphp

        @forelse($display_products as $product)
            @if($product->status != 'deleted')  <!-- شرط عدم ظهور المنتجات الممسوحة -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height:200px; object-fit:cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>السعر:</strong> ${{ $product->price }}</p>
                        <p class="card-text"><strong>الكمية:</strong> {{ $product->stock }}</p>
                        <p class="card-text"><strong>الفئة:</strong> {{ $product->category }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="GET" class="d-flex align-items-center">
                                <label class="me-2">الكمية:</label>
                                <input type="number" name="quantity" min="1" value="1" max="{{ $product->stock }}" class="form-control me-2" style="width:80px;">
                                <button type="submit" class="btn btn-success">أضف إلى السلة</button>
                            </form>
                        @else
                            <p class="text-danger mb-0">المنتج غير متوفر حالياً</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    لا توجد منتجات متاحة
                </div>
            </div>
        @endforelse
    </div>

    <!-- رسالة إذا كانت كل المنتجات محذوفة -->
    @php
        $active_products = $display_products->where('status', '!=', 'deleted');
    @endphp
    
    @if($active_products->count() == 0 && $display_products->count() > 0)
    <div class="alert alert-warning text-center">
        لا توجد منتجات متاحة للعرض حالياً
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>