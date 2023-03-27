<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            // 'book_id' => $this->book_id,
            'user_id' => $this->user_id,
            'book_name' => $this->whenLoaded('bookname'),
            'reviewer' => $this->whenLoaded('reviewer'),
            'review_book' => $this->review_book,
            'created_at' => $this->created_at->format('d/m/y')
        ];
    }
}
