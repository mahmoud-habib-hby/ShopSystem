<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
<h2>Add New Product (Admin Only)</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="/product" method="POST" enctype="multipart/form-data" >
    @csrf

    <label>Name:</label><br>
    <input type="text" name="name"><br><br>
    
    <label>category:</label><br>
    <input type="text" name="category"><br><br>
    
    <label>Description:</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Price:</label><br>
    <input type="number" step="0.01" name="price"><br><br>

    <label>Stock:</label><br>
    <input type="number" name="stock"><br><br>

    <label>Image:</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit">Add Product</button>
</form>

</body>
</html>
