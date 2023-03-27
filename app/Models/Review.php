<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'review_book'
    ];
    
    public function bookname(){
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    public function reviewer(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public function reviews(){
    //     return $this->hasMany(User::class, 'book_id', 'id');
    // }
}
