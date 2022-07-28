<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostUser extends Model
{
    use HasFactory;

    public $incrementing = true;
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $table = 'post_user';

    protected $fillable = [
        'post_id',
        'user_id',
    ];

    protected $hidden = [
        /* 'id', */];
}
