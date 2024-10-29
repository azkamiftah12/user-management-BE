<?php

namespace App;

use App\Models\AuditTrail;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait AuditTrailTrait
{
    protected function logAuditTrail( string $menuAccessed, string $method, string $changes, $writer_user_id )
    {
        
        $writer = User::findOrFail($writer_user_id);

        $auditTrail = AuditTrail::create([
            'user_id' => $writer_user_id,
            'username' => $writer->username,
            'menu_accessed' => $menuAccessed,
            'method' => $method,
            'change_details' => $changes,
        ]);

        return $auditTrail;
    }
}
