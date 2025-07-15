@php
function dash($val) {
    if (is_array($val)) {
        $filtered = array_filter($val, function($v) { return $v !== null && $v !== ''; });
        return count($filtered) ? implode('، ', $filtered) : '—';
    }
    return isset($val) && $val !== '' ? $val : '—';
}
@endphp


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض في شاشات الحرم: {{ $masjid->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --deep-forest: #174032;
            --warm-gold: #d4af37;
            --soft-cream: #faf9f6;
            --pure-white: #ffffff;
            --charcoal-dark: #2c3e50;
            --border-subtle: #e8e8e8;
            --primary-gradient: linear-gradient(135deg, #174032 0%, #174032 100%);
            --gold-gradient: linear-gradient(135deg, #d4af37 0%, #d4af37 100%);
            --background-gradient: linear-gradient(135deg, #faf9f6 0%, #faf9f6 100%);
            --card-gradient: linear-gradient(145deg, #ffffff 0%, #ffffff 100%);
            --border-radius: 10px;
            --border-radius-lg: 50px;
            --transition: all 0.2s ease-in-out;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: var(--soft-cream);
            font-family: 'Cairo', 'Amiri', serif;
        }
        body {
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            justify-content: flex-start;
        }
        .dashboard-header {
            background: var(--primary-gradient);
            color: var(--warm-gold);
            text-align: center;
            padding: 0.2vw 0 0.2vw 0;
            font-size: 1.5vw;
            font-family: 'Amiri', serif;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .masjid-name {
            color: var(--warm-gold);
            font-size: 1.5vw;
            font-weight: 900;
            margin-right: 0.5vw;
        }
        .info-bar {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: stretch;
            gap: 0.5vw;
            margin: 1vw 0 0.2vw 0;
            font-size: 0.9vw;
            width: 98vw;
            margin-left: auto;
            margin-right: auto;
        }
        .info-item {
            background: var(--pure-white);
            border-radius: var(--border-radius);
            box-shadow: 0 1px 4px rgba(23,64,50,0.07);
            padding: 0.15vw 0.3vw;
            flex: 1 1 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 0.9vw;
            border: 1px solid var(--border-subtle);
            margin: 0 0.1vw;
        }
        .info-label {
            color: var(--charcoal-dark);
            font-size: 0.7vw;
            font-weight: 700;
        }
        .info-value {
            color: var(--deep-forest);
            font-size: 0.9vw;
            font-weight: 900;
        }
        .marquee-container {
            background: var(--background-gradient);
            border-radius: var(--border-radius);
            padding: 0.1vw 0.7vw;
            margin: 0.2vw 0 0.5vw 0;
            font-size: 1vw;
            color: #b8860b;
            text-align: center;
            min-height: 1.5vw;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            height: 2vw;
            border: 1px solid var(--border-subtle);
            white-space: nowrap;
        }
        .marquee {
            display: inline-block;
            white-space: nowrap;
            will-change: transform;
            min-width: 100%;
            animation: scroll-right 20s linear infinite;
            font-size: 1vw;
        }
        .marquee .urgent {
            color: #e74c3c;
            font-weight: 900;
            margin-left: 1vw;
        }
        .marquee .normal {
            margin-left: 1vw;
        }
        @keyframes scroll-right {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .tables-vertical {
            display: flex;
            flex-direction: column;
            gap: 0.7vw;
            width: 100vw;
            align-items: stretch;
            justify-content: flex-start;
        }
        .table-section {
            background: var(--pure-white);
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(23,64,50,0.10);
            padding: 0.5vw 0.5vw 0.5vw 0.5vw;
            min-width: 0;
            width: 98vw;
            margin: 0 auto;
            font-size: 0.95vw;
            overflow: hidden;
            border: 1.5px solid var(--border-subtle);
        }
        .table-section h4 {
            color: var(--deep-forest);
            font-size: 1vw;
            font-weight: bold;
            margin-bottom: 0.2vw;
            margin-top: 0.1vw;
            text-align: right;
            background: var(--primary-gradient);
            color: var(--warm-gold);
            padding: 0.3vw 0.7vw;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            border-bottom: 2px solid var(--warm-gold);
            box-shadow: 0 1px 4px rgba(23,64,50,0.04);
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.85vw;
            background: var(--pure-white);
            border-radius: var(--border-radius);
            overflow: hidden;
        }
        th, td {
            border: 1px solid var(--border-subtle);
            padding: 0.15vw 0.2vw;
            text-align: center;
        }
        th {
            background: var(--primary-gradient);
            color: var(--warm-gold);
            font-weight: 700;
            border-bottom: 2px solid var(--warm-gold);
        }
        tbody tr {
            transition: var(--transition);
        }
        tbody tr:hover {
            background: #fffbe9;
        }
        @media (max-width: 1200px) {
            .dashboard-header { font-size: 1rem; }
            .masjid-name { font-size: 0.9rem; }
            .info-label, .info-value, .marquee, .table-section h4 { font-size: 0.8rem; }
        }
        @media (max-width: 900px) {
            .tables-vertical { gap: 0.3vw; }
            .table-section { width: 99vw; padding: 0.3vw; }
        }
    </style>
</head>
<body>

<div style="color:blue"></div>
    <div class="dashboard-header">
        <span class="masjid-name">{{ $masjid->name }}</span>
        
    </div>
    <div class="info-bar">
        <div class="info-item"><div class="info-label">المساحة الكلية</div><div class="info-value">{{ dash($masjid->total_area) }}</div></div>
        <div class="info-item"><div class="info-label">الطاقة الاستيعابية</div><div class="info-value">{{ dash($masjid->capacity) }}</div></div>
        <div class="info-item"><div class="info-label">عدد الأبواب</div><div class="info-value">{{ dash($masjid->gate_count) }}</div></div>
        <div class="info-item"><div class="info-label">عدد الأجنحة</div><div class="info-value">{{ dash($masjid->wing_count) }}</div></div>
        <div class="info-item"><div class="info-label">عدد قاعات الصلاة</div><div class="info-value">{{ dash($masjid->prayer_hall_count) }}</div></div>
        <div class="info-item"><div class="info-label">عدد الطواف بالساعة</div><div class="info-value">{{ dash($masjid->tawaf_per_hour) }}</div></div>
    </div>
    <div class="marquee-container">
        <div id="marquee-js" class="marquee"></div>
    </div>
    <script>
        // All announcements as JS objects
        const announcements = @json($announcementsArray);
        function isActive(a, now) {
            const start = a.start ? new Date(a.start.replace(/-/g, '/')) : null;
            const end = a.end ? new Date(a.end.replace(/-/g, '/')) : null;
            return (!start || now >= start) && (!end || now <= end);
        }
        function updateMarquee() {
            const now = new Date();
            const urgent = announcements.filter(a => a.is_urgent && isActive(a, now));
            const scheduled = announcements.filter(a => !a.is_urgent && isActive(a, now));
            let html = '';
            if (urgent.length || scheduled.length) {
                urgent.forEach(a => {
                    html += `<span class='urgent'><i class='fas fa-exclamation-triangle'></i> ${a.content}</span>`;
                });
                scheduled.forEach(a => {
                    html += `<span class='normal'>${a.content}</span>`;
                });
            } else {
                html = '<span>لا توجد إعلانات حالياً</span>';
            }
            document.getElementById('marquee-js').innerHTML = html;
        }
        updateMarquee();
        setInterval(updateMarquee, 1000);
    </script>
    <div class="tables-vertical">
        @if(isset($type) && $type === 'scientific')
            <div class="table-section">
                <h4><i class="fas fa-book-open"></i> الدروس العلمية</h4>
                <table>
                    <thead>
                        <tr>
                            <th>الكتاب</th>
                            <th>المجال</th>
                            <th>التخصص</th>
                            <th>المستوى</th>
                            <th>الحالة</th>
                            <th>من</th>
                            <th>إلى</th>
                            <th>الحضور</th>
                            <th>اللغة</th>
                            <th>ملاحظات</th>
                            <th>الموقع</th>
                            <th>المحاضر</th>
                            <th>رابط البث</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('masjids.partials.table_scientific_rows', ['programs' => $programs])
                    </tbody>
                </table>
            </div>
        @elseif(isset($type) && $type === 'halaqat')
            <div class="table-section">
                <h4><i class="fas fa-tasks"></i> الحلقات التحفيظية</h4>
                <table>
                    <thead>
                        <tr>
                            <th>رابط المعلم</th>
                            <th>المعلم</th>
                            <th>الموقع</th>
                            <th>ملاحظات</th>
                            <th>الحضور</th>
                            <th>اللغة</th>
                            <th>من</th>
                            <th>إلى</th>
                            <th>الحالة</th>
                            <th>المستوى</th>
                            <th>الحلقة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('masjids.partials.table_halaqat_rows', ['programs' => $programs])
                    </tbody>
                </table>
            </div>
        @elseif(isset($type) && $type === 'imama')
            <div class="table-section">
                <h4><i class="fas fa-user-tie"></i> جدول الأئمة</h4>
                <table>
                    <thead>
                        <tr>
                            <th>التاريخ</th>
                            <th>اليوم</th>
                            <th>إمام الفجر</th>
                            <th>أذان الفجر</th>
                            <th>إقامة الفجر</th>
                            <th>إمام الظهر</th>
                            <th>أذان الظهر</th>
                            <th>إقامة الظهر</th>
                            <th>إمام العصر</th>
                            <th>أذان العصر</th>
                            <th>إقامة العصر</th>
                            <th>إمام المغرب</th>
                            <th>أذان المغرب</th>
                            <th>إقامة المغرب</th>
                            <th>إمام العشاء</th>
                            <th>أذان العشاء</th>
                            <th>إقامة العشاء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('masjids.partials.table_imama_rows', ['programs' => $programs])
                    </tbody>
                </table>
            </div>
        @else
            @php $programs = collect($programs); @endphp
            <div class="table-section">
                <h4><i class="fas fa-book-open"></i> الدروس العلمية</h4>
                <table>
                    <thead>
                        <tr>
                            <th>الكتاب</th>
                            <th>المجال</th>
                            <th>التخصص</th>
                            <th>المستوى</th>
                            <th>الحالة</th>
                            <th>من</th>
                            <th>إلى</th>
                            <th>الحضور</th>
                            <th>اللغة</th>
                            <th>ملاحظات</th>
                            <th>الموقع</th>
                            <th>المحاضر</th>
                            <th>رابط البث</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('masjids.partials.table_scientific_rows', ['programs' => $programs->filter(function($p){ return $p->program_type === 'درس علمي'; })])
                    </tbody>
                </table>
            </div>
            <div class="table-section">
                <h4><i class="fas fa-tasks"></i> الحلقات التحفيظية</h4>
                <table>
                    <thead>
                        <tr>
                            <th>رابط المعلم</th>
                            <th>المعلم</th>
                            <th>الموقع</th>
                            <th>ملاحظات</th>
                            <th>الحضور</th>
                            <th>اللغة</th>
                            <th>من</th>
                            <th>إلى</th>
                            <th>الحالة</th>
                            <th>المستوى</th>
                            <th>الحلقة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('masjids.partials.table_halaqat_rows', ['programs' => $programs->filter(function($p){ return $p->program_type === 'حلقة تحفيظ'; })])
                    </tbody>
                </table>
            </div>
            <div class="table-section">
                <h4><i class="fas fa-user-tie"></i> جدول الأئمة</h4>
                <table>
                    <thead>
                        <tr>
                            <th>التاريخ</th>
                            <th>اليوم</th>
                            <th>إمام الفجر</th>
                            <th>أذان الفجر</th>
                            <th>إقامة الفجر</th>
                            <th>إمام الظهر</th>
                            <th>أذان الظهر</th>
                            <th>إقامة الظهر</th>
                            <th>إمام العصر</th>
                            <th>أذان العصر</th>
                            <th>إقامة العصر</th>
                            <th>إمام المغرب</th>
                            <th>أذان المغرب</th>
                            <th>إقامة المغرب</th>
                            <th>إمام العشاء</th>
                            <th>أذان العشاء</th>
                            <th>إقامة العشاء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('masjids.partials.table_imama_rows', ['programs' => $programs->filter(function($p){ return $p->program_type === 'إمامة'; })])
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>
</html> 