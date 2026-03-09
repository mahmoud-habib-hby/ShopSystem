<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>إضافة منتج جديد</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    background:#f5f7fb;
}
.container{
    max-width:600px;
    margin-top:50px;
}
.card{
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}
.success-message{
    background:#16a34a;
    color:white;
    padding:10px;
    border-radius:6px;
    text-align:center;
    margin-bottom:15px;
}
.error-list{
    color:#ef4444;
}
</style>
</head>
<body>

<div class="container">
<div class="card p-4">
<h3 class="mb-4 text-center">إضافة منتج جديد (Admin Only)</h3>

@if(session('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <ul class="error-list">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
<form action="/product" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">اسم المنتج:</label>
        <input type="text" name="name" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">الفئة (Category):</label>
        <input type="text" name="category" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">الوصف:</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">السعر:</label>
        <input type="number" step="0.01" name="price" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">الكمية:</label>
        <input type="number" name="stock" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">صورة المنتج:</label>
        <input type="file" name="image" class="form-control">
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">إضافة المنتج</button>
    </div>
</form>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>