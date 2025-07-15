<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الإعلان</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h1 class="mb-4">تفاصيل الإعلان</h1>
    <div class="mb-3"><strong>المعرف:</strong> {{ $announcement->id }}</div>
    <div class="mb-3"><strong>المحتوى:</strong> {{ $announcement->content }}</div>
    <div class="mb-3"><strong>الحالة:</strong> {{ $announcement->status == 'active' ? 'نشط' : 'غير نشط' }}</div>
    <div class="mb-3"><strong>تاريخ البدء:</strong> {{ $announcement->display_start_at }}</div>
    <div class="mb-3"><strong>تاريخ الانتهاء:</strong> {{ $announcement->display_end_at }}</div>
    <a href="{{ route('announcements.edit', $announcement) }}" class="btn btn-warning">تعديل</a>
    <a href="{{ route('announcements.index') }}" class="btn btn-secondary">رجوع</a>
</div>
</body>
</html>
