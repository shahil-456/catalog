<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('first_name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                ->orWhere('mobile', 'LIKE', "%{$searchTerm}%");
        }
        $users = $query->with('roles')->paginate(10);
        if ($request->ajax()) {
            return view('admin.users.list', compact('users'))->render();
        }
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.add', compact('roles'));
    }

    public function store(Request $request)
    {

        
        try {

            $validated = Validator::make($request->all(), [
                'firstname'     => 'required|string|max:100|min:3',
                'lastname'      => 'required|nullable|string|max:100|min:3',
                'email'         => 'required|email|max:200|unique:users,email',
                    'mobile'         => 'required|integer|min:10000000|max:1000000000000000|unique:users,mobile',
                'role_id' => 'required|exists:roles,id',
                'password'          => 'required|string|min:6|confirmed',


            ]);

            if ($validated->fails()) {
                return response()->json([
                    'errors' => $validated->errors(),
                ], 422);
            } else {

                $user = User::create([
                    'first_name'      => $request->input('firstname'),
                    'last_name'       => $request->input('lastname'),
                    'email'          => $request->input('email'),
                    'mobile'         => $request->input('mobile'),
                    'password' => Hash::make($request->input('password')),
                    'status'         => 1,
                ]);

                // $role = Role::findOrFail($request->role_id);
                // $user->syncRoles([$role]);;

                return response()->json(['success' => true, 'message' => 'User added successfully']);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error Adding Lead: ', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the lead. Please try again later.',
            ], 500);
        }
    }

    public function profile()
    {
        return view('admin.users.profile');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }


    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $validated = Validator::make($request->all(), [
                'firstname'     => 'required|string|max:100',
                'lastname'      => 'required|nullable|string|max:100',
                'email'         => 'required|email|max:200|unique:users,email,' . $request->id,
                'mobile'        => 'required|integer|max:1000000000000000000|unique:users,mobile,' . $request->id,
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'errors' => $validated->errors(),
                ], 422);
            }

            $user->update([
                'first_name'     => $request->input('firstname'),
                'last_name'      => $request->input('lastname'),
                'email'         => $request->input('email'),
                'mobile'        => $request->input('mobile'),
                'status'        => $request->input('status', 1),
                'updated_at'    => now(),
            ]);


            $role = Role::findOrFail($request->role_id);
            $user->syncRoles([$role]);;


            return response()->json(['success' => true, 'message' => 'User Updated successfully']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error Adding Lead: ', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the lead. Please try again later.',
            ], 500);
        }

        // Find the lead

    }


    public function destroy($id)
    {
        try {
            if (User::findOrFail($id)->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User deleted successfully!',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User could not be deleted. Please try again later.',
                ], 500);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting Laed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }
}
