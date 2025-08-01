<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'password_changed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relations
    public function scripts()
    {
        return $this->hasMany(Script::class, 'created_by');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function scriptViews()
    {
        return $this->hasMany(ScriptView::class);
    }

    // Méthodes pour vérifier les rôles
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEditeur()
    {
        return $this->role === 'editeur';
    }

    public function isLecteur()
    {
        return $this->role === 'lecteur';
    }

    public function isDSI()
    {
        return in_array($this->role, ['admin', 'editeur']);
    }

    public function isDTD()
    {
        return $this->role === 'lecteur';
    }
}
