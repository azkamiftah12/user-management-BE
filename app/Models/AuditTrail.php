<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'menu_accessed',
        'method',
        'timestamp',
        'change_details'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
