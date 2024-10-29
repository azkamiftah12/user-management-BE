<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\AuditTrailTrait;

class UserController extends Controller
{
    use AuditTrailTrait;

    public function index()
    {
        $users = User::with('role')->get(); 

        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'role_name' => $user->role ? $user->role->role_name : null, // Get role_name or null if no role
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Users retrieved successfully.',
            'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'writer_id' => 'required|exists:users,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        $this->logAuditTrail("User Manajemen", "Membuat User", "Create User: ".$request->username, $request->writer_id);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully.',
            'data' => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User retrieved successfully.',
            'data' => $user,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'username' => 'nullable|string|unique:users,username,' . $id,
            'password' => 'nullable|string|min:6',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
            ], 404);
        }

        $user->update([
            'name' => $request->name ?: $user->name,
            'username' => $request->username ?: $user->username,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'role_id' => $request->role_id ?: $user->role_id,
        ]);

        $this->logAuditTrail("User Manajemen", "Mengubah User", "Updated User: ".$request->username, $request->writer_id);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.',
            'data' => $user,
        ], 200);
    }


    public function destroy(String $id, Request $request)
    {
        $writerId = $request->input('writer_id');

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
            ], 404);
        }
        $this->logAuditTrail("User Manajemen", 'Menghapus User', "Delete User: ".$user->username, $writerId);
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.',
        ], 200);
    }
}
