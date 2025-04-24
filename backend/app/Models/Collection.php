<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collections';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'title',
        'description',
        'state_id'
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'collection_book', 'collection_id', 'book_id')
                ->withPivot('book_order')
                ->orderBy('pivot_book_order', 'asc');
    }
}
