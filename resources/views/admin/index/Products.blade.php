<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products</title>
    <!-- إضافة Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="{{ route("Delivry.form") }}"> add Delivery </a>
<a href="{{ route("admin.deliveries") }}"> All Delivery </a>
    <div class="container mt-5">
    <h1 class="mb-4">كل المنتجات</h1>

    <!-- رسالة النجاح -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height:fit-content; object-fit:cover; width:200px ;align-items: center:" >
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>السعر:</strong> ${{ $product->price }}</p>
                        <p class="card-text"><strong>الكمية:</strong> {{ $product->stock }}</p>
                        <p class="card-text"><strong>category:</strong> {{ $product->category }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <!-- زر التعديل -->
                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                        <!-- زر الحذف -->
                        <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>