<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;
use App\Events\AdminStatusChanged;


class LoginController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }


   public function login(Request $request)
{
    try {
        $validated = Validator::make($request->all(), [
            'email'    => 'required|email|exists:admins,email',
            'password' => 'required|min:6',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validated->errors(),
            ], 422);
        }

        $credentials = $validated->validated();

        if (Auth::guard('admin')->attempt($credentials)) {
            $adminId = Auth::guard('admin')->id();
            event(new AdminStatusChanged($adminId, true));
            Admin::where('id', $adminId)->update(['is_online' => true]);

            return response()->json([
                'success' => true,
                'redirect' => route('admin.users'),
            ]);
        }

        return response()->json([
            'success' => false,
            'login_error' => 'The provided credentials do not match our records.',
        ], 401);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors'  => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        \Log::error('Admin login error: ', ['exception' => $e]);
        return response()->json([
            'success' => false,
            'login_error' => 'Something went wrong. Please try again later.',
        ], 500);
    }
}



    public function logout()
    {
        $adminId = Auth::guard('admin')->id();
        event(new AdminStatusChanged($adminId, false));
        Admin::where('id', $adminId)->update(['is_online' => false]);
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

     public function register()
    {
        return view('admin.auth.register');
    }


    public function store(Request $request)
    {
        
        try {

            $validated = Validator::make($request->all(), [
                'full_name'     => 'required|string|max:100|min:3',
                'email'         => 'required|email|max:200|unique:admins,email',
                'phone'         => 'required|integer|min:10000000|max:1000000000000000|unique:admins,phone',
                'username'         => 'required|max:100|unique:admins,username',
                'password'          => 'required|string|min:6|confirmed',
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'errors' => $validated->errors(),
                ], 422);
            } else {

    
                $user = Admin::create([
                    'first_name'      => $request->input('full_name'),
                    'last_name'      => $request->input('full_name'),
                    'username'          => $request->input('username'),
                    'email'          => $request->input('email'),
                    'phone'         => $request->input('phone'),
                    'password' => Hash::make($request->input('password')),
                    'status'         => 1,
                ]);

                $credentials = [
                    'email'    => $request->input('email'),
                    'password' => $request->input('password'),
                ];

                if (Auth::guard('admin')->attempt($credentials)) {
                    return response()->json([
                        'success' => true,
                    ]);
                }

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

    

   
}
