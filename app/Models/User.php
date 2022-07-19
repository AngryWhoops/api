<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $incrementing = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'login',
        'subscription'
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }
}
