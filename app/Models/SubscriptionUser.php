<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionUser extends Model
{
    use HasFactory;

    public $incrementing = true;
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $table = 'subscription_user';

    protected $fillable = [
        'subscription_id',
        'user_id',
    ];

    protected $hidden = [
        'id',
        'pivot'
    ];
}
