@extends('layouts.admin')

@section('content')
<div class="admins-list-container" style="max-width:1200px;margin:0 auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="admins-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;">قائمة المشرفين</h2>
        <a href="{{ route('admin.users.create') }}" class="add-admin-btn">
            <i class="fas fa-user-plus"></i> إضافة مشرف جديد
        </a>
    </div>
    <div class="admins-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        <table class="admins-table" style="width:100%;border-collapse:separate;border-spacing:0 0.5rem;font-size:1.07rem;font-family:'Cairo',sans-serif;">
            <thead>
                <tr style="background:linear-gradient(135deg,#174032 0%,#174032 100%);color:#d4af37;font-weight:700;">
                    <th style="padding:1rem 0.5rem;text-align:center;">الاسم الكامل</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">البريد الإلكتروني</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">رقم الهاتف</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr class="admins-row" style="background:#fff;transition:background 0.18s;">
                        <td style="padding:0.9rem 0.5rem;text-align:center;font-weight:500;">{{ $admin->name }}</td>
                        <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $admin->email }}</td>
                        <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $admin->phone ?? '-' }}</td>
                        <td style="padding:0.9rem 0.5rem;text-align:center;">
                            <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-sm btn-warning" title="تعديل"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" style="display:inline-block;" class="delete-admin-form" data-admin-name="{{ $admin->name }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger delete-admin-btn" title="حذف" data-admin-id="{{ $admin->id }}"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">لا يوجد مشرفون بعد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.admins-list-container {
    font-family: 'Cairo', sans-serif;
    background: none;
    padding: 0.5rem;
}
.admins-title {
    margin-bottom: 0;
}
.add-admin-btn {
    background: linear-gradient(135deg, #174032 0%, #14532d 100%);
    color: #d4af37;
    padding: 0.6rem 1.5rem;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 700;
    font-family: 'Cairo', sans-serif;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s;
    border: none;
}
.add-admin-btn:hover {
    background: #14532d;
    color: #fffbe6;
    transform: translateY(-2px);
}
.admins-table th, .admins-table td { border: none !important; }
.admins-row:hover { background: #faf9f6 !important; }
@media (max-width: 768px) {
    .admins-list-container {
        padding: 0.5rem;
    }
    .admins-title {
        font-size: 1.2rem;
    }
    .add-admin-btn {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }
    .admins-table th, .admins-table td {
        padding: 0.6rem 0.5rem !important;
        font-size: 0.95rem;
    }
    .admins-table-card {
        padding: 1.2rem 0.5rem !important;
    }
}
</style>
@endsection

@section('scripts')
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(135deg,#174032 0%,#14532d 100%);color:#d4af37;">
        <h5 class="modal-title" id="deleteAdminModalLabel"><i class="fas fa-exclamation-triangle"></i> تأكيد حذف المشرف</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
      </div>
      <div class="modal-body" style="font-family:'Cairo',sans-serif;">
        <p>هل أنت متأكد أنك تريد حذف المشرف التالي؟</p>
        <div id="adminNameToDelete" style="font-weight:900;color:#174032;font-size:1.2rem;"></div>
        <p class="text-danger mt-2 mb-0"><i class="fas fa-info-circle"></i> لا يمكن التراجع عن هذا الإجراء.</p>
      </div>
      <div class="modal-footer" style="display: flex; flex-direction: row; gap: 0.5rem; align-items: center; justify-content: flex-end; direction: rtl;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteAdminBtn"><i class="fas fa-trash-alt"></i> حذف</button>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let formToDelete = null;
    const modal = new bootstrap.Modal(document.getElementById('deleteAdminModal'));
    const adminNameElem = document.getElementById('adminNameToDelete');
    document.querySelectorAll('.delete-admin-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            formToDelete = btn.closest('form');
            const adminName = formToDelete.getAttribute('data-admin-name');
            adminNameElem.textContent = adminName;
            modal.show();
        });
    });
    document.getElementById('confirmDeleteAdminBtn').addEventListener('click', function() {
        if (formToDelete) {
            formToDelete.submit();
        }
        modal.hide();
    });
});
</script>
@endsection 