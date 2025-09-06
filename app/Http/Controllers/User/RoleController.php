<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::query();
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }
        $roles = $query->paginate(10);
        if ($request->ajax()) {
            return view('admin.roles.list', compact('roles'))->render();
        }
        return view('admin.roles.index', compact('roles'));
    }
    public function addRole()
    {
        $permissions = Permission::all();
        return view('admin.roles.add', compact('permissions'));
    }
    public function createRole(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:roles,name',
                'permissions' => 'required|array',
            ]);
            $role = Role::create([
                'name' => $request->input('name'),
                'guard_name' => 'web',
            ]);


            $role = Role::findOrFail($role->id);
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);


            return response()->json(['success' => true, 'message' => 'Role added successfully']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error inserting role: ', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the role. Please try again later.',
            ], 500);
        }
    }
    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $selectedPermission = $role->permissions->pluck('name')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'selectedPermission'));
    }
    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        try {
            $request->validate([
                'name' => 'required|unique:roles,name,' . $role->id,
                'permissions' => 'required|array',
            ]);
            $role->update([
                'name' => $request->input('name'),
            ]);
            $role->syncPermissions($request->input('permissions'));
            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully.'
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error updating role: ', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the department. Please try again later.',
            ], 500);
        }
    }
    public function deleteRole($id)
    {
        try {
            if (Role::findOrFail($id)->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role deleted successfully!',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Role could not be deleted. Please try again later.',
                ], 500);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting Role: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }

    public function getPermissionsByGuard(Request $request)
    {
        $request->validate([
            'guard' => 'required|string'
        ]);

        $permissions = Permission::where('guard_name', $request->guard)->get(['name']);
        return response()->json(['permissions' => $permissions]);
    }
}
