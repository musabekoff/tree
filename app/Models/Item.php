<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use Sluggable;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'main'
            ]
        ];
    }

    public function parents()
    {
        return $this->hasMany(Item::class, 'parent_id', 'id');
    }

    public function childrenParents()
    {
        return $this->hasMany(Item::class, 'parent_id', 'id')->with('parents');
    }
}
