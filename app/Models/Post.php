<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Post extends Model
{
    use HasFactory;

    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';
    public $table = 'posts';

    protected $casts = [
        'created_at' => 'date:d.m.Y ',
        'updated_at' => 'date:d.m.Y ',
    ];

    protected $fillable = [
        'body',
    ];

    protected $hidden = [
        /* 'id', */
        'user_id',
        'pivot',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hashtags(): BelongsToMany
    {
        return $this->belongsToMany(Hashtag::class);
    }

    public function markedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_user');
    }

    public function subscribedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
