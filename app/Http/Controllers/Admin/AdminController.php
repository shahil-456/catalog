<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Admin::query()->where('id', '!=', auth()->id());

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                ->orWhere('phone', 'LIKE', "%{$searchTerm}%");
            });
        }

        $admins = $query->paginate(10);

        if ($request->ajax()) {
            return view('admin.admins.list', compact('admins'))->render();
        }

        return view('admin.admins.index', compact('admins'));
    }


    public function create()
    {
        $roles = Role::all();
        return view('admin.admins.add', compact('roles'));
    }

    public function store(Request $request)
    {
        
    
        try {

            $validated = Validator::make($request->all(), [
                'first_name'     => 'required|string|max:100|min:3',
                'last_name'      => 'required|nullable|string|max:100|min:3',
                'email'         => 'required|email|max:200|unique:admins,email',
                'phone'         => 'required|integer|min:10000000|max:1000000000000000|unique:admins,phone',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:3048',                
                 'adminname'         => 'required|max:100|unique:admins,adminname',
                // 'role_id' => 'required|exists:roles,id',
                'password'          => 'required|string|min:6|confirmed',


            ]);

            if ($validated->fails()) {
                return response()->json([
                    'errors' => $validated->errors(),
                ], 422);
            } else {

            


                $imageName = null;
                if ($request->hasFile('photo')) {
                $image      = $request->file('photo');
                $imageName  = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('admins'), $imageName); 
                $imageName = 'admins/'.$imageName; 
                }

                $admin = Admin::create([
                    'first_name'      => $request->input('first_name'),
                    'last_name'       => $request->input('last_name'),
                    'adminname'          => $request->input('adminname'),
                    'email'          => $request->input('email'),
                    'phone'         => $request->input('phone'),
                    'profile_photo'         => $imageName,              
                    'password' => Hash::make($request->input('password')),
                    'status'         => 1,
                ]);

                

                // $role = Role::findOrFail($request->role_id);
                // $admin->syncRoles([$role]);;

                return response()->json(['success' => true, 'message' => 'Admin added successfully']);
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
                'message' => 'An error occurred while adding the Admin. Please try again later.',
            ], 500);
        }
    }

    public function profile()
    {
        return view('admin.admins.profile');
    }
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $roles = Role::all();
        return view('admin.admins.edit', compact('admin', 'roles'));
    }


    public function update(Request $request, $id)
    {

        
        try {
            $admin = Admin::findOrFail($id);
            
            $validated = Validator::make($request->all(), [
                'first_name'     => 'required|string|max:100',
                'last_name'      => 'required|nullable|string|max:100',
                'email'         => 'required|email|max:200|unique:admins,email,' . $request->id,
                'phone'        => 'required|integer|max:1000000000000000000|unique:admins,phone,' . $request->id,
                'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:3048',                

            ]);




            if ($validated->fails()) {
                return response()->json([
                    'errors' => $validated->errors(),
                ], 422);
            }

            $imageName = null;

            if ($request->hasFile('photo')) {
                $image      = $request->file('photo');
                $imageName  = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('admins'), $imageName); 
                $imageName = 'admins/'.$imageName; 
            }


            $admin->update([
                'first_name'     => $request->input('first_name'),
                'last_name'      => $request->input('last_name'),
                'email'         => $request->input('email'),
                'phone'        => $request->input('phone'),
                'status'        => $request->input('status', 1),
                'updated_at'    => now(),
                'profile_photo'         => $imageName,              
               
            ]);


            // $role = Role::findOrFail($request->role_id);
            // $admin->syncRoles([$role]);;


            return response()->json(['success' => true, 'message' => 'Admin Updated successfully']);
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

    public function show($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.admins.view', compact('admin'));
    }



    public function destroy($id)
    {
        // return 1;
        try {
            if (Admin::findOrFail($id)->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin deleted successfully!',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin could not be deleted. Please try again later.',
                ], 500);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Admin not found.',
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
