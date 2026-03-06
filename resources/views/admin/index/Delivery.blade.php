<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الدليفري</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body dir="rtl">

<div class="container mt-5">
    <h2 class="mb-4 text-center">قائمة الدليفري</h2>

    @if($deliveries->isEmpty())
        <div class="alert alert-info text-center">
            لا يوجد دليفري
        </div>
    @else
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الإيميل</th>
                    <th>تاريخ التسجيل</th>
                    <th>details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($deliveries as $delivery)
                    <tr>
                        <td>{{ $delivery->id }}</td>
                        <td>{{ $delivery->name }}</td>
                        <td>{{ $delivery->email }}</td>
                        <td>{{ $delivery->created_at->format('Y-m-d') }}</td>
                        <td><a href="{{ route('admin.details',$delivery->id) }}">details</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

</body>
</html>