<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'role',
        'content',
        'retrieved_routes',
        'timing_data',
    ];

    protected $casts = [
        'retrieved_routes' => 'array',
        'timing_data'      => 'array',
    ];

    /**
     * Get the user that owns the message
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: messages for a given session
     */
    public function scopeForSession($query, string $sessionId)
    {
        return $query->where('session_id', $sessionId)->orderBy('created_at', 'asc');
    }
}
