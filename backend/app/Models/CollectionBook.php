<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionBook extends Model
{
    protected $table = 'collection_book';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'book_order',
        'collection_id',
        'book_id'
    ];
}
