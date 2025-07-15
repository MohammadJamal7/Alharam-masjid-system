@php
    $masjids = [
        [
            'name' => 'المسجد الحرام',
            'icon' => '<i class="fas fa-kaaba"></i>'
        ],
        [
            'name' => 'المسجد النبوي',
            'icon' => '<i class="fas fa-mosque"></i>'
        ],
        [
            'name' => 'الكل',
            'icon' => '<i class="fas fa-mosque"></i>'
        ],
    ];
    $features = [
        ['icon' => '<i class="fas fa-bullhorn"></i>', 'text' => 'شاشة موزعة في مواقع محددة في المسجد الحرام والمسجد النبوي'],
        ['icon' => '<i class="fas fa-chart-bar"></i>', 'text' => 'إحصائيات عامة عن المسجدين'],
        ['icon' => '<i class="fas fa-bullhorn"></i>', 'text' => 'تسهيل إعلان محاضرة'],
        ['icon' => '<i class="fas fa-tasks"></i>', 'text' => 'إدارة برامج ودروس وخدمات التخطيط'],
        ['icon' => '<i class="fas fa-calendar-check"></i>', 'text' => 'مواعيد التسجيل في البرامج والدروس'],
        ['icon' => '<i class="fas fa-clipboard-list"></i>', 'text' => 'مواعيد الاختبارات'],
        ['icon' => '<i class="fas fa-chalkboard-teacher"></i>', 'text' => 'مواعيد الدورات'],
        ['icon' => '<i class="fas fa-bell"></i>', 'text' => 'إشعار بتأجيل أو إلغاء الدروس والمحاضرات'],
    ];
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الهيئة العامة للعناية بشؤون المسجد الحرام والمسجد النبوي</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&family=Amiri:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --deep-forest: #174032;
            --warm-gold: #d4af37;
            --soft-cream: #faf9f6;
            --pure-white: #ffffff;
            --charcoal-dark: #2c3e50;
            --border-subtle: #e8e8e8;
            --font-heading: 'Cairo', sans-serif;
            --font-body: 'Cairo', sans-serif;
        }
        body {
            background: var(--soft-cream);
            color: var(--charcoal-dark);
            font-family: var(--font-body);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-header {
            background: var(--deep-forest);
            border: none;
            box-shadow: none;
            padding: 1.2rem 0 1.1rem 0;
            position: relative;
        }
        .main-header::after {
            content: '';
            display: block;
            height: 4px;
            width: 100%;
            background: var(--warm-gold);
            position: absolute;
            bottom: 0;
            left: 0;
            border-radius: 0 0 8px 8px;
        }
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--deep-forest);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--warm-gold);
            font-size: 1.3rem;
            border: 2px solid var(--warm-gold);
        }
        .logo-title {
            font-family: var(--font-heading);
            font-size: 1.35rem;
            font-weight: 900;
            color: var(--pure-white);
            margin: 0;
            letter-spacing: 0.5px;
        }
        .main-container {
            flex: 1;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            min-height: 70vh;
            padding: 4.5rem 2vw 0 2vw;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            gap: 6vw;
        }
        .masjid-side, .features-side {
            background: none;
            border: none;
            box-shadow: none;
            border-radius: 0;
            padding: 0 3vw;
            margin: 0;
        }
        .masjid-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-width: 320px;
        }
        .features-side {
            flex: 1.1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            min-width: 320px;
        }
        .features-title {
            font-family: var(--font-heading);
            font-size: 1.15rem;
            font-weight: 900;
            color: var(--deep-forest);
            margin-bottom: 1.2rem;
            text-align: right;
        }
        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 1.1rem;
        }
        .features-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.7rem;
            font-size: 1.05rem;
            color: var(--charcoal-dark);
        }
        .features-list .icon {
            color: var(--warm-gold);
            font-size: 1.1rem;
            margin-top: 0.1rem;
        }
        .masjid-side h2 {
            font-family: var(--font-heading);
            font-size: 1.25rem;
            font-weight: 900;
            color: var(--deep-forest);
            margin-bottom: 0.7rem;
            text-align: center;
        }
        .masjid-side p {
            font-size: 1.05rem;
            color: #444;
            margin-bottom: 2.2rem;
            text-align: center;
        }
        .masjid-btns {
            display: flex;
            flex-direction: column;
            gap: 1.1rem;
            margin-bottom: 2.2rem;
            width: 100%;
            max-width: 350px;
        }
        .masjid-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
            background: var(--pure-white);
            border: 2px solid var(--border-subtle);
            border-radius: 10px;
            font-family: var(--font-heading);
            font-size: 1.13rem;
            font-weight: 700;
            color: var(--deep-forest);
            padding: 1.1rem 0.5rem;
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            width: 100%;
        }
        .masjid-btn.selected, .masjid-btn:focus, .masjid-btn:hover {
            border-color: var(--warm-gold);
            background: #fffbe9;
            box-shadow: 0 4px 16px rgba(212, 175, 55, 0.08);
        }
        .masjid-btn .icon {
            font-size: 1.5rem;
            color: var(--warm-gold);
        }
        .cta-btn {
            background: var(--warm-gold);
            color: var(--deep-forest);
            border: none;
            border-radius: 50px;
            font-family: var(--font-heading);
            font-size: 1.13rem;
            font-weight: 900;
            padding: 1rem 2.5rem;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(212, 175, 55, 0.13);
            margin-top: 0.5rem;
            width: 100%;
            max-width: 220px;
        }
        .cta-btn:hover, .cta-btn:focus {
            background: var(--deep-forest);
            color: var(--warm-gold);
            outline: 2px solid var(--warm-gold);
        }
        .footer {
            margin-top: 2.5rem;
            padding: 1.2rem 0 0.5rem 0;
            text-align: center;
            font-size: 0.95rem;
            color: #888;
            font-family: var(--font-body);
        }
        @media (max-width: 1000px) {
            .main-container { flex-direction: column; align-items: stretch; gap: 3rem; padding-top: 2rem; }
            .masjid-side, .features-side { padding: 0 1.2rem; }
        }
        @media (max-width: 600px) {
            .header-content { flex-direction: column; gap: 0.7rem; }
            .masjid-side, .features-side { padding: 0 0.5rem; }
        }
        .masjid-btns a.masjid-btn {
            text-decoration: none !important;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <div class="logo-icon"><i class="fas fa-mosque"></i></div>
            <h1 class="logo-title">الهيئة العامة للعناية بشؤون المسجد الحرام والمسجد النبوي</h1>
        </div>
    </header>
    <div class="main-container">
        <div class="masjid-side">
            <h2>اختر المسجد</h2>
            <p>يرجى اختيار المسجد الذي ترغب في عرض فعالياته.</p>
            <div class="masjid-btns" id="masjidBtns">
                @foreach($masjids as $i => $masjid)
                    @if($masjid['name'] === 'المسجد الحرام')
                        <a href="{{ route('masjids.home', 1) }}" class="masjid-btn" tabindex="0" style="text-decoration:none !important; width:100%; display:block; text-align:center;">
                            <span class="icon">{!! $masjid['icon'] !!}</span>
                            <span>{{ $masjid['name'] }}</span>
                        </a>
                    @elseif($masjid['name'] === 'المسجد النبوي')
                        <a href="{{ route('masjids.home', 2) }}" class="masjid-btn" tabindex="0" style="text-decoration:none !important; width:100%; display:block; text-align:center;">
                            <span class="icon">{!! $masjid['icon'] !!}</span>
                            <span>{{ $masjid['name'] }}</span>
                        </a>
                    @else
                        <a href="#" class="masjid-btn" tabindex="0" style="width:100%; display:block; text-decoration:none !important; text-align:center;">
                            <span class="icon">{!! $masjid['icon'] !!}</span>
                            <span>{{ $masjid['name'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
            <button class="cta-btn" id="startBtn" style="display:none;">ابدأ العرض</button>
        </div>
        <div class="features-side" aria-label="الشاشة التفاعلية">
            <div class="features-title">الشاشة التفاعلية</div>
            <ul class="features-list">
                @foreach($features as $feature)
                <li><span class="icon">{!! $feature['icon'] !!}</span> <span>{{ $feature['text'] }}</span></li>
                @endforeach
            </ul>
        </div>
    </div>
    <footer class="footer">
        <span>حقوق الهيئة العامة للعناية بشؤون المسجد الحرام والمسجد النبوي محفوظة</span>
    </footer>
    <script>
        // Remove JS selection logic as buttons are now direct links
    </script>
</body>
</html>
