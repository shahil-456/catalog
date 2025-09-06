<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Log;


class PermissionController extends Controller
{

     public function index(Request $request)
    {
        $query = Permission::query();
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }
        $permissions = $query->paginate(10);
        if ($request->ajax()) {
            return view('admin.permissions.list', compact('permissions'))->render();
        }
        return view('admin.permissions.index', compact('permissions'));
    }





    public function create()
    {
        return view('admin.permissions.add');
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
        'name' => 'required|string|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);
        return response()->json(['success' => true, 'message' => 'Permission added successfully']);
        }
         catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error Adding Service: ', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the service Please try again later.',
            ], 500);
        }



    }


    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('admin.permissions.edit', compact( 'permission'));
    }


    public function update(Request $request, $id)
    {

        try {
            $request->validate([
                'name' => 'required|unique:permissions,name'
            ]);
            $permission = Permission::findOrFail($id);

            $permission->update([
                'name' => $request->input('name'),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Permission updated successfully.'
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permissions not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error updating Permissions: ', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the permission. Please try again later.',
            ], 500);
        }
    }

     public function destroy($id)
    {
        try {
            if (Permission::findOrFail($id)->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permission deleted successfully!',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Permission could not be deleted. Please try again later.',
                ], 500);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permission not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting Permission: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }




}
