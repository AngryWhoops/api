<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class HashtagPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashtag_id',
        'post_id',
    ];

    public $incrementing = true;
    public $timestamps = false;
}
