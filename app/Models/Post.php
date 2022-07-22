<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';
    public $table = 'posts';

    protected $casts = [
        'created_at' => 'date:d.m.Y H:i',
        'updated_at' => 'date:d.m.Y H:i'
    ];

    protected $fillable = [
        'body',
        'user_author',
    ];

    /* public function author() {
        return $this->hasOne(User::class);
    } */

    public function user() {
        return $this->belongsTo(User::class);
    }

    /* public function hashtags() {
        return $this->belongsToMany(Hashtag::class);
    } */

}
