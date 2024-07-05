<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'author', 'genre_id', 'publication_year', 'isbn', 'copies_available'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}

