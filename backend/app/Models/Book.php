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
        'original_thumbnail_url',
        'version',
        'size',
        'zip_download_url',
        'zip_download_google_drive_file_id',
        'original_zip_download_url',
        'cefr_level',
        'type_readers',
        'type_gradebook',
        'type_gradebook_answer_revealable',
        'type_classroom_presentation'
    ];
}
