<?php

namespace App\Http\Resources;

use App\Models\Item;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class MainItemResource extends JsonResource
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
            'content' => $this->content,
            'back'    => $this->backLink($this->parent_id),
            'image'   => $this->image ? asset($this->image) : '',
            'items'   => ItemResource::collection(Item::query()->where('parent_id', $this->id)->orderByDesc('id')->get()->values())
        ];
    }

    private function backLink($parentId) {
        $main = Item::query()->where('id', $parentId);

        if ($main->value('parent_id') === 0) {
            return ['slug' => false, 'main' => $main->value('main')];
        } else {
            return ['slug' => $main->value('slug'), 'main' => $main->value('main')];
        }
    }
}
