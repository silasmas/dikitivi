<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class Media extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [ 
            'id' => $this->id,
            'media_title' => $this->media_title,
            'media_description' => $this->media_description,
            'source' => $this->source,
            'belonging_count' => $this->belonging_count,
            'time_length' => $this->time_length,
            'media_url' => $this->media_url,
            'teaser_url' => $this->teaser_url,
            'author_names' => $this->author_names,
            'artist_names' => $this->artist_names,
            'writer' => $this->writer,
            'director' => $this->director,
            'published_date' => $this->published_date,
            'cover_url' => $this->cover_url != null ? (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://admin.dikitivi.com/public/storage/' . $this->cover_url : null,
            'thumbnail_url' => $this->thumbnail_url != null ? (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://admin.dikitivi.com/public/storage/' . $this->thumbnail_url : null,
            'price' => $this->price,
            'for_youth' => $this->for_youth,
            'is_live' => $this->is_live,
            'belongs_to' => $this->belongs_to,
            'type' => Type::make($this->type),
            'categories' => Category::collection($this->categories)->unique('id')->all(),
            'created_at_ago' => timeAgo($this->created_at->format('Y-m-d H:i:s')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at_ago' => timeAgo($this->updated_at->format('Y-m-d H:i:s')),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'user_id' => $this->user_id,
            'is_public' => $this->is_public
        ];
    }
}
