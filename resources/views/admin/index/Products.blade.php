<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>كل المنتجات</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f5f7fb;
}

.navbar{
background:#1e293b;
}

.navbar a{
color:white !important;
margin-left:15px;
}

.card{
border:none;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,0.08);
transition:0.3s;
}

.card:hover{
transform:translateY(-5px);
}

.product-img{
height:200px;
object-fit:cover;
border-top-left-radius:12px;
border-top-right-radius:12px;
}

.price{
color:#16a34a;
font-weight:bold;
font-size:18px;
}

.stock{
color:#2563eb;
}

.btn-edit{
background:#3b82f6;
color:white;
}

.btn-delete{
background:#ef4444;
color:white;
}

.btn-stock{
background:#10b981;
color:white;
}

</style>

</head>
<body>

<!-- Navbar -->
<nav class="navbar p-3 mb-4">
<div class="container">
<a href="{{ route('Delivry.form') }}">إضافة مندوب</a>
<a href="{{ route('product.delete') }}">المنتجات المحذوفة</a>
<a href="{{ route('admin.deliveries') }}">كل المندوبين</a>
<a href="{{ route('admin.orders') }}">كل الطلبات</a>
<a href="product/create">اضافة منتج</a>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-danger">تسجيل الخروج</button>
</form>

</div>
</nav>

<div class="container">

<h2 class="mb-4 text-center fw-bold">كل المنتجات</h2>

@if(session('success'))
<div class="alert alert-success text-center">
{{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger text-center">
{{ session('error') }}
</div>
@endif

<div class="row">

@forelse($products as $product)

    @if($product->status != 'deleted')  <!-- شرط عدم ظهور المنتجات الممسوحة -->
    <div class="col-md-4 mb-4">

    <div class="card h-100">

    @if($product->image)
    <img src="{{ asset('storage/' . $product->image) }}" class="product-img" alt="{{ $product->name }}">
    @endif

    <div class="card-body">

    <h5 class="fw-bold">{{ $product->name }}</h5>

    <p class="text-muted small">{{ $product->description }}</p>

    <p class="price">السعر : ${{ $product->price }}</p>

    <p class="stock">الكمية : {{ $product->stock }}</p>

    <p class="text-secondary">التصنيف : {{ $product->category }}</p>

    </div>

    <div class="card-footer bg-white">

    <div class="d-flex justify-content-between mb-2">

    <a href="{{ route('product.edit',$product->id) }}" class="btn btn-edit btn-sm">
    تعديل
    </a>

    <form action="{{ route('product.destroy',$product->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من نقل المنتج إلى الممسوحة؟')">
    حذف
    </button>
    </form>

    </div>

    <form action="{{ route('add.stock',$product->id) }}" method="get" class="d-flex mb-2">
    <input type="number" class="form-control form-control-sm me-2" name="stock" placeholder="إضافة كمية" required min="1">
    <button class="btn btn-stock btn-sm">إضافة</button>
    </form>

    <form action="{{ route('remove.stock',$product->id) }}" method="get" class="d-flex">
    <input type="number" class="form-control form-control-sm me-2" name="stock" placeholder="سحب كمية" required min="1" max="{{ $product->stock }}">
    <button class="btn btn-warning btn-sm">سحب</button>
    </form>

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

<!-- إضافة قسم للمنتجات الممسوحة (اختياري) -->
@if(Auth::user()->type == 'admin')
<div class="mt-5">
    <h4 class="mb-3">المنتجات الممسوحة</h4>
    <div class="row">
        @foreach($products as $product)
            @if($product->status == 'deleted')
            <div class="col-md-3 mb-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6>{{ $product->name }}</h6>
                        <p class="small text-muted">{{ $product->description }}</p>
                        <a href="{{ route('product.restore',$product->id) }}" class="btn btn-success btn-sm">استعادة</a>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>
@endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>