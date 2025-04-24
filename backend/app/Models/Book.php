<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'public_id',
        'title',
        'description',
        'thumbnail_url',
        'version',
        'size',
        'zip_download_url',
        'is_downloaded',
        'type_readers',
        'type_gradebook',
        'type_gradebook_answer_revealable',
        'type_classroom_presentation'
    ];
}
