<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookDetailResource extends JsonResource
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
            'title' => $this->title,
            'image' => $this->image,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'description' => $this->description,
            'reviews' => $this->whenLoaded('reviews', function () {
                return collect($this->reviews)->each(function($review){
                    $review->reviewer;
                    return $review;
                });
            }),
            // 'reviews' => $this->whenLoaded('reviews'),
            // 'reviewer' => $this->whenLoaded('reviewer')
        ];
    }
}
