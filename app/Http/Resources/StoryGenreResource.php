<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoryGenreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'bookTitle' => $this->title,
            'image' => $this->cover,
            'partCount' => $this->parts->count(),
            'bookAuthor' => $this->user->fullname,
            'review' => [
                'ratingCount' => $this->reviews->count(),
                'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star') / $this->reviews->count(), 1) : 0.0,
            ],
        ];
    }
}
