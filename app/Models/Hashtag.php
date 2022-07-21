<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $table = 'hashtags';

    protected $fillable = [
        'hashtag'
    ];

    /* public function posts() {
        return $this->belongsToMany(Post::class);
    } */
}
