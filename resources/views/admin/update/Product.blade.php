<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>تعديل المنتج</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">تعديل المنتج: {{ $product->name }}</h1>

    <!-- عرض الأخطاء -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">الاسم:</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}">
        </div>

        <div class="mb-3">
            <label class="form-label">الوصف:</label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">category</label>
            <textarea name="category" class="form-control">{{ $product->category}}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">السعر:</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}">
        </div>

        <div class="mb-3">
            <label class="form-label">الكمية:</label>
            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
        </div>

        <div class="mb-3">
            <label class="form-label">الصورة الحالية:</label><br>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="height:120px; object-fit:cover;">
            @else
                <p>لا توجد صورة</p>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">تغيير الصورة (اختياري):</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">تحديث المنتج</button>
        <a href="{{ route('product.index') }}" class="btn btn-secondary">رجوع لكل المنتجات</a>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>