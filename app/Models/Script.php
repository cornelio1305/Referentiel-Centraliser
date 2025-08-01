<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'content',
        'version',
        'status',
        'category',
        'dependencies',
        'metadata',
        'views_count',
        'rating',
        'rating_count',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'dependencies' => 'array',
        'metadata' => 'array',
        'rating' => 'decimal:2',
    ];

    // Relations
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function views()
    {
        return $this->hasMany(ScriptView::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    public function scopeRated($query)
    {
        return $query->orderBy('rating', 'desc');
    }

    // Méthodes
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function addRating($rating)
    {
        $this->rating_count++;
        $this->rating = (($this->rating * ($this->rating_count - 1)) + $rating) / $this->rating_count;
        $this->save();
    }

    public function isFavoritedBy($user)
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }
}
