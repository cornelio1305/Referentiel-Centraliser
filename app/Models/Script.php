<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Script extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'content',
        'version',
        'status',
        'db_target',
        'server_name',
        'database_name',
        'author',
        'affected_objects',
        'related_application',
        'related_job',
        'documentation',
        'dependencies',
        'file_path',
        'file_name',
        'file_size',
        'checksum',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'affected_objects' => 'array',
        'dependencies' => 'array',
    ];

    // Relations
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(ScriptVersion::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(ScriptView::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    // Scopes pour le filtrage
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByDbTarget($query, $dbTarget)
    {
        return $query->where('db_target', $dbTarget);
    }

    public function scopeByAuthor($query, $author)
    {
        return $query->where('author', 'like', "%{$author}%");
    }

    public function scopeByServer($query, $server)
    {
        return $query->where('server_name', 'like', "%{$server}%");
    }

    // Méthodes utilitaires
    public function createVersion($changeReason = null)
    {
        return $this->versions()->create([
            'version' => $this->version,
            'content' => $this->content,
            'description' => $this->description,
            'metadata' => [
                'db_target' => $this->db_target,
                'server_name' => $this->server_name,
                'database_name' => $this->database_name,
                'author' => $this->author,
                'affected_objects' => $this->affected_objects,
                'related_application' => $this->related_application,
                'related_job' => $this->related_job,
            ],
            'change_reason' => $changeReason,
            'created_by' => auth()->id(),
        ]);
    }

    public function incrementViews()
    {
        $this->views()->create([
            'user_id' => auth()->id(),
            'viewed_at' => now(),
        ]);
    }

    public function getViewsCountAttribute()
    {
        return $this->views()->count();
    }

    public function isFavoritedBy($userId)
    {
        return $this->favorites()->where('user_id', $userId)->exists();
    }

    public function getDbTargetLabelAttribute()
    {
        $labels = [
            'postgresql' => 'PostgreSQL',
            'mysql' => 'MySQL',
            'sqlserver' => 'SQL Server',
            'db2' => 'DB2',
            'oracle' => 'Oracle',
            'other' => 'Autre',
        ];

        return $labels[$this->db_target] ?? $this->db_target;
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'draft' => 'Brouillon',
            'active' => 'Actif',
            'inactive' => 'Inactif',
            'archived' => 'Archivé',
        ];

        return $labels[$this->status] ?? $this->status;
    }
}
