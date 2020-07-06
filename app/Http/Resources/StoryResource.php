<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $library = $this->libraries->where('status', 'ACTIVE')->first();
        $my_library = null;
        if ($library) {
            $my_library = [
                'id' => $library->id,
                'access_type' => $library->access_type,
                'expired_at' => $library->expired_at,
            ];
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->cover,
            'description' => $this->description,
            'language' => $this->language,
            'status' => $this->status,
            'partCount' => $this->parts->count(),
            'genre' => $this->genre->name,
            'author' => $this->user->fullname,
            'licence' => $this->licence->name,
            'library' => $my_library,
            'review' => [
                'ratingCount' => $this->reviews->count(),
                'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star') / $this->reviews->count(), 1) : 0.0,
            ],
            // 'parts' => $this->parts()->get(),
            'tags' => TagsResource::collection($this->tags()->get()),
        ];
    }
}
