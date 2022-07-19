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

    protected $fillable = [
        'body'
    ];

    public function author() {
        return $this->hasOne(User::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function hashTags() {
        return $this->belongsToMany(Hashtag::class);
    }
}
