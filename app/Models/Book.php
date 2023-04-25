<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function scopeFilter($query)
    {


        return $query->get();
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'book_users', 'book_id', 'user_id');
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
