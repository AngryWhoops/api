<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    public $incrementing = true;
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $table = 'users';

    protected $fillable = [
        'login',
    ];

    protected $hidden = [
        'id',
        'pivot'
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function markedOnPosts(): BelongsToMany
    {
        return $this->BelongsToMany(Post::class);
    }
}
