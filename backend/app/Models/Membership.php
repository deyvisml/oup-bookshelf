<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'memberships';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'expiry_date',
        'user_id',
        'collection_id'
    ];
}
