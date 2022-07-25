<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
