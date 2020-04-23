<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'content' => $this->content,
            'created_at' => $this->created_at,
            'author' => [
                'name' => $this->author->name, 
                'email' => $this->author->email, 
            ],
            'children' => CommentResource::collection($this->children),
        ];
    }
}
