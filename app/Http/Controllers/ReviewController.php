<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'review_book' => 'required'
        ]);

        $request['user_id'] = auth()->user()->id;

        $review = Review::create($request->all());
        // return response()->json($review);
        return new ReviewResource($review->loadMissing(['reviewer:id,username','bookname:id,title']));
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'review_book' => 'required'
        ]);

        $review = Review::findOrFail($id);
        $review->update($request->only('review_book'));

        return new ReviewResource($review->loadMissing(['reviewer:id,username','bookname:id,title']));
    }

    public function destroy($id){
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json([
            'review' => $review,
            'message' => 'review deleted successfully'
        ]);
    }
}
