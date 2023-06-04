<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'main'    => $this->main,
            'spouse'  => $this->spouse,
            'slug'    => $this->slug,
            'parentId'    => $this->parent_id,
            'content' => $this->content,
            'image'   => $this->image ? asset($this->image) : '',
        ];
    }
}
