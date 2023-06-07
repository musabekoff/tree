<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainItemResource;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function main()
    {
       $data = Item::query()
           ->where('parent_id', null)
           ->orderByDesc('id')
           ->limit(1)
           ->get()
           ->values();

       if ($data) {
           return MainItemResource::collection($data)->resolve();
       }
       return response()->json('Not Found Main', 429);
    }
    public function item($slug)
    {
       $data = Item::query()
           ->where('slug', $slug)
           ->get()
           ->values();

       if ($data) {
           return MainItemResource::collection($data)->resolve();
       }
       return response()->json('Not Found Main', 429);
    }

    public function set(Request $request): array
    {
        $model = new Item();
        $model->main = $request->main;
        $model->content = $request->text;
        $model->spouse = $request->spouse;
        $model->parent_id = $request->parent_id;
        if ($request->image) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('items'), $imageName);
            $model->image = '/items/'.$imageName;
        }
        $model->save();
        $data = Item::query()
            ->where('id', $request->parent_id)
            ->get()
            ->values();
        return MainItemResource::collection($data)->resolve();
    }

    public function update(Request $request)
    {
        $model = Item::find($request->id);
        $model->main = $request->main;
        $model->content = $request->text;
        $model->slug = null;
        $model->spouse = $request->spouse;
        if ($request->file('image')) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('items'), $imageName);
            $model->image = '/items/'.$imageName;
        }
        $model->save();
        if ($request->isMain === 'true') {
            $data = Item::query()
                ->where('id', $request->id)
                ->get()
                ->values();
        } else {
            $data = Item::query()
                ->where('id', intval($request->parentId) ? $request->parentId : null)
                ->get()
                ->values();
        }
        return MainItemResource::collection($data)->resolve();
    }

    public function deleteImage($id, $isMain)
    {
        $item = Item::query()->find($id);
        File::delete(mb_substr($item->image, 1));
        $item->image = NULL;
        $item->save();

        if ($isMain === 'true') {
            $data = Item::query()
                ->where('id', $id)
                ->get()
                ->values();
        } else {
            $data = Item::query()
                ->where('id', $item->parent_id)
                ->get()
                ->values();
        }

        if ($data) {
            return MainItemResource::collection($data)->resolve();
        }
        return response()->json('Not Found Main', 429);
    }

    public function delete($id)
    {
        $item = Item::query()->where('id', $id);
        Storage::delete($item->value('image'));

        $data = Item::query()
            ->where('id', $item->value('parent_id'))
            ->get()
            ->values();

        $item->delete();

        if ($data) {
            return MainItemResource::collection($data)->resolve();
        }
        return response()->json('Not Found Main', 429);
    }

    private function deleteItem($id) {
        return Item::query()->where('parent_id', $id)->get('id')->values();
    }
}
