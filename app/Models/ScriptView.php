<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScriptView extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'script_id',
        'viewed_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function script()
    {
        return $this->belongsTo(Script::class);
    }
}
