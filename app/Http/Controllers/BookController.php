<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookDetailResource;

class BookController extends Controller
{
    public function index(){
        $books = Book::all();
        // return response()->json($books);
        return BookResource::collection($books);
    }

    public function show($id) {
        $book = Book::findOrFail($id);
        return new BookDetailResource($book);
    }
}
