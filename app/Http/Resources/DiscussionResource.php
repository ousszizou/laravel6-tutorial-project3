<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscussionResource extends JsonResource
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
            "id" => $this->id,
            "title" => $this->title,
            "content" => $this->content,
            "user" => $this->user,
            "channel" => $this->channel,
            "slug" => $this->slug,
            "replies" => ReplyResource::collection($this->replies) ,
            "replies_count" => $this->replies->count(),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "published_at" => $this->created_at->diffForHumans()
        ];
    }
}
