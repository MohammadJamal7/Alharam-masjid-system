@extends('layouts.admin')

@section('content')
<div class="create-admin-container" style="max-width:1200px;margin:0 auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="create-admin-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;">إضافة مشرف جديد</h2>
    </div>

    <div class="form-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="card-title">
                <h2>بيانات المشرف</h2>
                <p>يرجى ملء جميع الحقول المطلوبة</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="admin-form">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-user"></i>
                        الاسم الكامل
                    </label>
                    <input type="text" id="name" name="name" class="form-input" 
                           value="{{ old('name') }}" required 
                           placeholder="أدخل الاسم الكامل" autocomplete="off">
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i>
                        البريد الإلكتروني
                    </label>
                    <input type="email" id="email" name="email" class="form-input" 
                           value="{{ old('email') }}" required 
                           placeholder="أدخل البريد الإلكتروني" autocomplete="off">
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i>
                        كلمة المرور
                    </label>
                    <input type="password" id="password" name="password" class="form-input" 
                           required placeholder="أدخل كلمة المرور" autocomplete="off">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-lock"></i>
                        تأكيد كلمة المرور
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="form-input" required placeholder="أعد إدخال كلمة المرور" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone"></i>
                        رقم الهاتف
                    </label>
                    <input type="tel" id="phone" name="phone" class="form-input" 
                           value="{{ old('phone') }}" 
                           placeholder="أدخل رقم الهاتف" autocomplete="off">
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fas fa-save"></i>
                    إضافة المشرف
                </button>
                <a href="{{ route('admin.dashboard') }}" class="cancel-btn">
                    <i class="fas fa-times"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.create-admin-container {
    font-family: 'Cairo', sans-serif;
    /* background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); */
    /* min-height: 100vh; */
    padding: 0.5rem 0.5rem 0.5rem 0.5rem;
}

/* Form Card */
.form-card {
    background: #faf9f6;
    border-radius: 16px;
    padding: 1rem 1rem;
    box-shadow: 0 4px 24px rgba(30,41,59,0.07);
    border-top: 5px solid #d4af37;
    width: 100%;
}

.card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #f0f0f0;
}

.card-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #d4af37 0%, #b8941f 100%);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.3rem;
}

.card-title h2 {
    color: #174032;
    font-size: 1.6rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
}

.card-title p {
    color: #6c757d;
    font-size: 1rem;
    margin: 0;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.form-group {
    position: relative;
    margin-bottom: 1.1rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #174032;
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 0.3rem;
}

.form-label i {
    color: #d4af37;
    font-size: 1.1rem;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 2px solid #e8e8e8;
    border-radius: 12px;
    font-size: 1rem;
    font-family: 'Cairo', sans-serif;
    background: #fff;
    color: #2c3e50;
    transition: all 0.3s ease;
    height: 45px;
}

.form-input:focus {
    outline: none;
    border-color: #d4af37;
    background: #fffbe6;
    box-shadow: 0 4px 16px rgba(212, 175, 55, 0.1);
}

.form-input::placeholder {
    color: #6c757d;
    opacity: 0.7;
}

.error-message {
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 0.25rem;
    display: block;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    margin-top: 1rem;
}

.submit-btn, .cancel-btn {
    padding: 0.75rem 2rem;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 700;
    font-family: 'Cairo', sans-serif;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    border: none;
}

.submit-btn {
    background: linear-gradient(135deg, #174032 0%, #14532d 100%);
    color: #d4af37;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(23, 64, 50, 0.2);
}

.cancel-btn {
    background: #f8f9fa;
    color: #6c757d;
    border: 2px solid #e8e8e8;
}

.cancel-btn:hover {
    background: #e9ecef;
    color: #495057;
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .create-admin-container {
        padding: 0.5rem;
    }
    
    .page-header {
        padding: 2rem 1rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .form-card {
        padding: 1rem;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .submit-btn, .cancel-btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 1.8rem;
    }
    
    .card-header {
        flex-direction: column;
        text-align: center;
    }
    
    .card-icon {
        width: 50px;
        height: 50px;
        font-size: 1.3rem;
    }
}
</style>
@endsection 