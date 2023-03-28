<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'author',
        'publisher',
        'description',
        'pages'
    ];
    
    public function reviewer(){
        return $this->belongsTo(User::class, 'user_id', 'id')->select(['username']);
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'book_id', 'id');
    }
    

}
