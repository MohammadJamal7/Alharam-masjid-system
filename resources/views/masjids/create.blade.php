@extends('layouts.admin')

@section('content')
<x-breadcrumb :items="[['title' => 'المساجد', 'url' => route('masjids.index')], ['title' => 'إضافة مسجد جديد']]" />
<div class="masjids-page-container" style="max-width:1200px;margin:0 auto;">
    <div class="masjids-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('masjids.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اسم المسجد</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-mosque input-inside-icon"></i>
                        <input type="text" name="name" class="form-control" required value="{{ old('name') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المساحة الكلية</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-ruler-combined input-inside-icon"></i>
                        <input type="text" name="total_area" class="form-control" value="{{ old('total_area') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المساحة المغطاة (م²)</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-ruler-combined input-inside-icon"></i>
                        <input type="number" step="0.01" name="covered_area_sqm" class="form-control" value="{{ old('covered_area_sqm') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">السعة</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-users input-inside-icon"></i>
                        <input type="number" name="capacity" class="form-control" value="{{ old('capacity') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">عدد البوابات</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-door-open input-inside-icon"></i>
                        <input type="number" name="gate_count" class="form-control" value="{{ old('gate_count') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">عدد الأجنحة</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-building input-inside-icon"></i>
                        <input type="number" name="wing_count" class="form-control" value="{{ old('wing_count') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">عدد قاعات الصلاة</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-praying-hands input-inside-icon"></i>
                        <input type="number" name="prayer_hall_count" class="form-control" value="{{ old('prayer_hall_count') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">عدد الطواف في الساعة</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-sync-alt input-inside-icon"></i>
                        <input type="number" name="tawaf_per_hour" class="form-control" value="{{ old('tawaf_per_hour') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                    </div>
                </div>
            </div>
            
            <!-- الحقول الجديدة -->
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">معلومات عامة عن المسجد</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-info-circle input-inside-icon"></i>
                        <textarea name="general_info" class="form-control" rows="3" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;padding-right:2.3rem;">{{ old('general_info') }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">خدمات متاحة في المسجد</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-concierge-bell input-inside-icon"></i>
                        <textarea name="available_services" class="form-control" rows="3" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;padding-right:2.3rem;">{{ old('available_services') }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">إحصائيات عامة عن المسجد</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-chart-bar input-inside-icon"></i>
                        <textarea name="general_statistics" class="form-control" rows="3" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;padding-right:2.3rem;">{{ old('general_statistics') }}</textarea>
                    </div>
                </div>
            </div>
            

            
            <div class="d-flex justify-content-center gap-3 mt-4">
                <button type="submit" class="btn btn-primary" style="border-radius:8px;background:#d4af37;color:#174032;font-weight:700;font-family:'Cairo',sans-serif;padding:0.7rem 2.1rem;font-size:1.07rem;min-width:140px;">حفظ المسجد</button>
                <a href="{{ route('masjids.index') }}" class="btn btn-secondary" style="border-radius:8px;background:#174032;color:#fff;font-family:'Cairo',sans-serif;padding:0.7rem 2.1rem;font-size:1.07rem;min-width:140px;">إلغاء</a>
            </div>
        </form>
    </div>
</div>
<style>
    .masjids-page-container { font-family: 'Cairo', sans-serif; }
    .masjids-table-card input.form-control:focus {
        border-color: #174032;
        box-shadow: 0 0 0 2px #d4af37;
        outline: none;
    }
    .input-icon i { color: #C9B037; font-size: 1.1em; }
    .input-group-text.input-icon {
        background: transparent;
        border: none;
        padding-right: 0.75rem;
        padding-left: 0.75rem;
        display: flex;
        align-items: center;
    }
    .input-group .form-control {
        margin-right: 0 !important;
        margin-left: 0 !important;
    }
    .masjids-table-card .btn-primary:focus, .masjids-table-card .btn-primary:hover {
        background: #174032 !important;
        color: #fff !important;
        border: 1.5px solid #174032 !important;
    }
    .masjids-table-card .btn-secondary:focus, .masjids-table-card .btn-secondary:hover {
        background: #d4af37 !important;
        color: #174032 !important;
        border: 1.5px solid #d4af37 !important;
    }
    .input-icon-wrapper {
        position: relative;
    }
    .input-inside-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #C9B037;
        font-size: 1.1em;
        pointer-events: none;
        z-index: 2;
    }
    .input-icon-wrapper input.form-control {
        padding-right: 2.3rem;
    }
</style>
@endsection