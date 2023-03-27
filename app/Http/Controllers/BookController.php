<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Storage;
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
        return new BookDetailResource($book->loadMissing(['reviewer:id,username','reviews:id,book_id,user_id,review_book']));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'description' => 'required',
            'pages' => 'required|integer',
            'file' => 'nullable|mimes:jpeg,jpg,png|image|max:2048'
        ]);

        // $image = null;
        // if ($request->file) {
        // $fileName = $this->generateRandomString();
        // $extension = $request->file->extension();

        // $image = $fileName.'.'.$extension;
        // Storage::putFileAs('image', $request->file, $image);
        // }

        $request->validate([
        'file' => 'required|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $path = $request->file('file')->store('uploads');

        $request['image'] = $path;
        $book = Book::create($request->all());
        return new BookDetailResource($book);
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'description' => 'required',
            'pages' => 'required|integer'
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());

        return new BookDetailResource($book);
    }

    public function destroy($id){
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json([
            'message' => 'deleted data success'
        ]);
    }

    public function generateRandomString($length = 40) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
}
