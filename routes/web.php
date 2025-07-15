<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\LectureController;



// Admin Login Route
Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

Route::post('/admin/login', function () {
    $credentials = request()->only('email', 'password');
    
    if (Auth::attempt($credentials, request('remember'))) {
        request()->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }
    
    return back()->withErrors([
        'email' => 'بيانات الدخول غير صحيحة.',
    ]);
})->name('admin.login.post');

// Custom admin logout route
Route::post('/admin/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/admin/login');
})->name('admin.logout');

// Protect all admin dashboard and admin management pages
Route::middleware('auth')->group(function () {
    
    // Admin User Management Routes
    Route::get('/admin/users/create', function () {
        return view('admin.create-admin');
    })->name('admin.users.create');

    Route::post('/admin/users', function () {
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // 'role' => 'required|in:admin,super_admin', // removed
            'phone' => 'nullable|string|max:20',
        ]);
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            // 'role' => $validated['role'], // removed
            'phone' => $validated['phone'] ?? null,
        ]);
        return redirect()->route('admin.dashboard')->with('success', 'تم إضافة المشرف بنجاح');
    })->name('admin.users.store');

    Route::get('/admin/dashboard', function () {
        $masjidsCount = \App\Models\Masjid::count();
        $programsCount = \App\Models\Program::count();
        $announcementsCount = \App\Models\Announcement::count();
        $usersCount = \App\Models\User::count();
        return view('admin.dashboard', compact('masjidsCount', 'programsCount', 'announcementsCount', 'usersCount'));
    })->name('admin.dashboard');

    // Admins list page
    Route::get('/admin/admins', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.admins.index');
    // Admin edit/update/delete
    Route::get('/admin/admins/{id}/edit', [\App\Http\Controllers\AdminController::class, 'edit'])->name('admin.admins.edit');
    Route::put('/admin/admins/{id}', [\App\Http\Controllers\AdminController::class, 'update'])->name('admin.admins.update');
    Route::delete('/admin/admins/{id}', [\App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.admins.destroy');


Route::resource('masjids', \App\Http\Controllers\MasjidController::class);
Route::resource('masjids.programs', \App\Http\Controllers\ProgramController::class);
Route::resource('locations', \App\Http\Controllers\LocationController::class);
Route::resource('announcements', AnnouncementController::class);
Route::resource('lectures', LectureController::class);
   
    Route::get('masjids/{masjid}/programs/{program}/edit', [\App\Http\Controllers\ProgramController::class, 'edit'])->name('masjids.programs.edit');
    Route::put('masjids/{masjid}/programs/{program}', [\App\Http\Controllers\ProgramController::class, 'update'])->name('masjids.programs.update');
    

});



Route::get('/', function () {
    return view('welcome');
});


Route::get('/masjids/{masjid}/home', [\App\Http\Controllers\MasjidController::class, 'home'])->name('masjids.home');

Route::get('/masjids/{masjid}/filter/scientific', [\App\Http\Controllers\MasjidController::class, 'filterScientific'])->name('masjids.filter.scientific');
Route::get('/masjids/{masjid}/filter/halaqat', [\App\Http\Controllers\MasjidController::class, 'filterHalaqat'])->name('masjids.filter.halaqat');
Route::get('/masjids/{masjid}/filter/imama', [\App\Http\Controllers\MasjidController::class, 'filterImama'])->name('masjids.filter.imama');
Route::get('/masjids/{masjid}/filter/all', [\App\Http\Controllers\MasjidController::class, 'filterAll'])->name('masjids.filter.all');
    Route::get('/masjids/{masjid}/display', [\App\Http\Controllers\MasjidController::class, 'display'])->name('masjids.display');


require __DIR__.'/auth.php';
