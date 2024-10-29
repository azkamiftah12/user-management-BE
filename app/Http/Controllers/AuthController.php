<?php

namespace App\Http\Controllers;

use App\AuditTrailTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use AuditTrailTrait;
    
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        
        if (Auth::attempt($request->only('username', 'password'))) {
            $this->logAuditTrail("Login", "Login User", "Login User: ".$request->username, Auth::user()->id);
            $user = Auth::user();
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => [
            'user' => $user,
            'role_name' => $user->role->role_name, // Include the role name
        ],
            ], 200);
        }
        


        
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid username or password',
        ], 401);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        $this->logAuditTrail("Register User", "Membuat User", "Register User: ".$request->username, $user->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Register successfully.',
            'data' => $user,
        ], 201);
    }
}
