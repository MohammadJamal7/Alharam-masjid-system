<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Models\Masjid;
use App\Models\Program;
use App\Models\ProgramType;
use App\Models\StructuredProgram;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function create_admin()  {
        $permissions = \App\Models\Permission::all();
        $masjids = \App\Models\Masjid::all();
        $programTypes = ProgramType::orderBy('name')->get();
        $structuredPrograms = StructuredProgram::with('programType')->orderBy('title')->get();
        return view('admin.create-admin', compact('permissions', 'masjids', 'programTypes', 'structuredPrograms'));
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
        $admins = User::orderBy('created_at', 'desc')->get();
        return view('admin.admins', compact('admins'));
    }

    // Show the permission assignment form for an admin
    public function permissions($id)
    {
        $admin = User::findOrFail($id);
        $permissions = \App\Models\Permission::all(); // Always a Collection
        $masjids = Masjid::all();
        $programTypes = ProgramType::orderBy('name')->get();
        $assigned = $admin->permissions()->get();
        return view('admin.assign-permissions', compact('admin', 'permissions', 'masjids', 'programTypes', 'assigned'));
    }

    // Handle the permission assignment form submission
    public function updatePermissions(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        $data = $request->input('permissions', []);
        
        // Debug the incoming data
        Log::info('Permission update data', ['data' => $data]);
        
        $syncData = [];
        
        foreach ($data as $permissionId => $scopes) {
            // Handle masjid permissions
            if (isset($scopes['masjids'])) {
                foreach ($scopes['masjids'] as $masjidId) {
                    $syncData[] = [
                        'permission_id' => $permissionId,
                        'masjid_id' => $masjidId,
                        'program_type' => null,
                    ];
                }
            }
            
            // Handle program type permissions
            if (isset($scopes['program_types'])) {
                foreach ($scopes['program_types'] as $programTypeId) {
                    $syncData[] = [
                        'permission_id' => $permissionId,
                        'masjid_id' => null,
                        'program_type' => $programTypeId,
                    ];
                }
            }
            
            // Handle super program permissions (applies to all program types)
            if (isset($scopes['super_program'])) {
                // Get all program types and assign permission to each
                $programTypes = \App\Models\ProgramType::all();
                foreach ($programTypes as $programType) {
                    $syncData[] = [
                        'permission_id' => $permissionId,
                        'masjid_id' => null,
                        'program_type' => $programType->id,
                    ];
                }
            }
            
            // Handle general permissions
            if (isset($scopes['general'])) {
                $syncData[] = [
                    'permission_id' => $permissionId,
                    'masjid_id' => null,
                    'program_type' => null,
                ];
            }
        }
        
        // Debug the sync data
        Log::info('Permission sync data', ['syncData' => $syncData]);
        
        // Remove old permissions and attach new
        $admin->permissions()->detach();
        
        foreach ($syncData as $row) {
            $admin->permissions()->attach($row['permission_id'], [
                'masjid_id' => $row['masjid_id'],
                'program_type' => $row['program_type'],
            ]);
        }
        return redirect()->route('admin.admins.index')->with('success', 'تم تحديث صلاحيات المشرف بنجاح');
    }

    // Show all admins for permission assignment
    // public function permissionsAdmins()
    // {
    //     $admins = User::all();
    //     return view('admin.permissions-admins', compact('admins'));
    // }
}
