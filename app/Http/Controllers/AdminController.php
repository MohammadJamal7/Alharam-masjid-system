<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function create_admin()  {
        return view('admin.create-admin');
    }

    // Show the form for editing the specified admin
    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.edit-admin', compact('admin'));
    }

    // Update the specified admin in storage
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->phone = $validated['phone'] ?? null;
        if (!empty($validated['password'])) {
            $admin->password = bcrypt($validated['password']);
        }
        $admin->save();
        return redirect()->route('admin.admins.index')->with('success', 'تم تحديث بيانات المشرف بنجاح');
    }

    // Remove the specified admin from storage
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();
        return redirect()->route('admin.admins.index')->with('success', 'تم حذف المشرف بنجاح');
    }

    // List all admins
    public function index()
    {
        $admins = User::all();
        return view('admin.admins', compact('admins'));
    }
}
