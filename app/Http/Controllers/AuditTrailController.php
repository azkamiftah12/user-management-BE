<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auditTrails = AuditTrail::with('user')->get();

        $auditTrailsData = $auditTrails->map(function ($auditTrail) {
            return [
                'id' => $auditTrail->id,
                'user_id' => $auditTrail->user_id,
                'username' => $auditTrail->user->username ?? null,
                'menu_accessed' => $auditTrail->menu_accessed,
                'method' => $auditTrail->method,
                'change_details' => $auditTrail->change_details,
                'role_name' => $auditTrail->user->role->role_name,
                'created_at' => $auditTrail->created_at,
                'updated_at' => $auditTrail->updated_at,
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Users retrieved successfully.',
            'data' => $auditTrailsData,
        ], 200);
    }

    
}
