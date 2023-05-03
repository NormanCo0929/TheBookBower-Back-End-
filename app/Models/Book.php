<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'published', 'description', 'isbn'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
