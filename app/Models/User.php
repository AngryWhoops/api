<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $incrementing = true;
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $table = 'users';

    protected $fillable = [
        'login',
        'subscriptions'
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    /* public function userSubscriptions() {
        return $this->hasMany(User::class);
    } */
}
